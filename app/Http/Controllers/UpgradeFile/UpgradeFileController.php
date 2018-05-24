<?php

namespace App\Http\Controllers\UpgradeFile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\UpgradeFile;
use App\FileTypes;
use Redirect,Auth;

class UpgradeFileController extends Controller
{
	//public $module=['search','upgrade_file'];
	public $module = 'upgrade_file';
	//public $parent_module = 'upgrade_file';
    public function index()
    {
		$ugfs = UpgradeFile::latest('id')->paginate(10);
		return view('upgrade_file.index')->withUgfs($ugfs);
	}
	
	public function create()
    {
		$fts = FileTypes::where('status',1)->get();
		return view('upgrade_file.create')->withFts($fts);
	}
	
	public function store(Request $request)
	{
		$this->validate($request, [
		'code' => 'required',
		'language' => 'required',
		'upload_pack' => 'required',
		]);
		
		$sys_code = $request->input('code');
		$language = $request->input('language');
		$file = $request->file('upload_pack');		
		//$file_content = file_get_contents($file);
			
		$file_name  = $file->getClientOriginalName();
		$name_exp = explode(".", $file_name);
		$pack_postfix = strtolower((string)$name_exp[1]);
		$pack_name = strtolower((string)$name_exp[0]);
		$file_size = $file->getSize();
		
		$patten = "/^\d{4}(0?[1-9]|1[012])(0?[1-9]|[12][0-9]|3[01])$/";
		if(!preg_match($patten,$pack_name)){
			return Redirect::back()->withInput()->withErrors('升级包名称不符合规定,格式为YYYYMMDD.postfix！');
		}	
		
		$sys_info = FileTypes::where('code',$sys_code)->first();	
		$sys_postfix = $sys_info->postfix;		
		$sys_folder = $sys_info->folder;

		if($pack_postfix != $sys_postfix){
			return Redirect::back()->withInput()->withErrors('升级包与所属系统不一致！');
		}

		$sql_file_date = UpgradeFile::where('code',$sys_code)->max('end_version');
		
		if($sql_file_date == ''){
			$sql_file_date="20160101";
		}
		
		if( strcmp($sql_file_date,$pack_name) >= 0){
			return Redirect::back()->withInput()->withErrors('升级包日期较早，请上传最新升级包！');
		}
		
		$new_filename = $sql_file_date."-".$file_name;
		$file_md5 = md5($file);
		$file->move(storage_path().'/app/UpdatePacket/'.$sys_folder, $new_filename);
		
		$ugfs = new UpgradeFile();
		$ugfs->code = $sys_code;
		$ugfs->language = $language;
		$ugfs->name = $new_filename;
		$ugfs->file_md5 = $file_md5;
		$ugfs->size = $file_size;
		$ugfs->start_version = $sql_file_date;
		$ugfs->end_version = $pack_name;
		
		$ugfs->user = Auth::user()->name;
				//$apps->user = Auth::user()->getAuthIdentifier();
	
		$ugfs->save();		
	
		return Redirect::to('upgrade_file');

		
	}
	
	public function download($id)
    {
		
		$ugfs = UpgradeFile::find($id);
		$file_name = $ugfs->name;
		$sys_code = $ugfs->code;
		$sys_info = FileTypes::where('code',$sys_code)->first();
		$sys_folder = $sys_info->folder;
		
		$download_path = storage_path().'/app/UpdatePacket/'.$sys_folder.'/'.$file_name;
				
		if(!is_file($download_path)){
			return Redirect::back()->withInput()->withErrors('升级包不存在！');
		}
		
		$file_size = filesize($download_path); 
		
		Header("Content-type: application/octet-stream"); 
		Header("Content-Disposition: attachment; filename=".basename($download_path));
		header("Content-Length: ".$file_size);
		readfile($download_path);
	}
	
	public function edit(Request $request)
	{
		$id = $request->route('id');
		$ugfs = UpgradeFile::find($id);
		$fts = FileTypes::where('status',1)->get();
		return view('upgrade_file.edit')->withUgfs($ugfs)->withFts($fts);
	}
	
	public function update(Request $request,$id)
	{
		$this->validate($request, [
		]);
		
		
		$ugfs = UpgradeFile::find($id);
		$sql_file_name = $ugfs->name;

		if ($ugfs) {
			$ugfs->language = $request->input('language');
			$ugfs->description = $request->input('description');
			$sys_code = $request->input('code');
			$ugfs->user = Auth::user()->name;
			
			if($request->hasFile('upload_pack')){
				$file = $request->file('upload_pack');
				//$file_content = file_get_contents($file);	
				$file_name  = $file->getClientOriginalName();
				$name_exp = explode(".", $file_name);
				$pack_postfix = strtolower((string)$name_exp[1]);
				$pack_name = strtolower((string)$name_exp[0]);
				$file_size = $file->getSize();
					
				$patten = "/^\d{4}(0?[1-9]|1[012])(0?[1-9]|[12][0-9]|3[01])$/";
				if(!preg_match($patten,$pack_name)){
					return Redirect::back()->withInput()->withErrors('升级包名称不符合规定！');
				}	
				
				$sys_info = FileTypes::where('code',$sys_code)->first();	
				$sys_postfix = $sys_info->postfix;		
				$sys_folder = $sys_info->folder;

				if($pack_postfix != $sys_postfix){
					return Redirect::back()->withInput()->withErrors('升级包与所属系统不一致！');
				}				
									
				$sql_file_date = $ugfs->end_version;
													
				if( strcmp($sql_file_date,$pack_name) > 0){
					return Redirect::back()->withInput()->withErrors('升级包日期较早，请上传最新升级包！');
				}

			
				$file_md5 = md5($file);
				$file->move(storage_path().'/app/UpdatePacket/'.$sys_folder, $sql_file_name);
				$ugfs->file_md5 = $file_md5;
				$ugfs->size = $file_size;
			}
			$ugfs->save();
		}
		return Redirect::to('upgrade_file');
	}
	
	public function search(Request $request)
    {
		//$ugfs = UpgradeFile::paginate(10);
		$fts = FileTypes::where('status',1)->get();
		$key = $request->input('key');
		$start_version = $request->input('start_version');
		$end_version = $request->input('end_version');
		$sys_code = $request->input('code');
	
		if (isset($key)) {
			$ugfs = UpgradeFile::latest('id')->where('name', 'like', '%'.$key.'%');
			if (isset($sys_code) && $sys_code != '') {
				$ugfs = $ugfs->where('code', '=', $sys_code);
			}
			if (isset($start_version) && $start_version != '') {
				if ($start_version > $end_version && $end_version != '' ){
					return Redirect()->back()->withInput()->withErrors('起始日期必须小于截止日期！');
				}
				$ugfs = $ugfs->where('start_version', '>=', $start_version);
			}
			if (isset($end_version) && $end_version != '') {
				$ugfs = $ugfs->where('end_version', '<=', $end_version);
			}
			$ugfs = $ugfs->latest('id')->paginate(10);
		} else {
			$ugfs = UpgradeFile::latest('id')->paginate(10);
		}
		return view('upgrade_file.search')->withUgfs($ugfs)->withFts($fts)->withInput(Input::all());
	}
}
