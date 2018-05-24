<?php

namespace App\Http\Controllers\FileTypes;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\FileTypes;
use Input,Redirect,Auth;

class FileTypesController extends Controller
{
	public $module = 'file_types';
    public function index()
    {
        $fts = FileTypes::All();
		//$ac=AcGenerate::All();
		return view('file_types.index')->withFts($fts);
    }
	
	public function create()
    {
        //$fts = FileTypes::All();
		//$ac=AcGenerate::All();
		return view('file_types.create');
    }
	
	public function store(Request $request)
	{
		$this->validate($request, [
		'type' => 'required|unique:filetypes',
		'code' => 'required|unique:filetypes|integer',
		'postfix' => 'required',
		'folder' => 'required',
		]);
		$fts = new FileTypes();
		$fts->type = $request->input('type');
		$fts->code = $request->input('code');
		$fts->postfix = $request->input('postfix');
		$fts->folder = $request->input('folder');
		$fts->description = $request->input('description');
		$fts->user = Auth::user()->name;
		$fts->status = 1;
		//$fts->user = Auth::user()->getAuthIdentifier();
		//$cp->user = Auth::User()->name;
		if(!file_exists(storage_path().'/app/UpdatePacket/'.$request->input('folder'))){
			mkdir(storage_path().'/app/UpdatePacket/'.$request->input('folder'));
		}
		$fts->save();
		return Redirect::to('file_types');
	}
	
	public function edit(Request $request)
    {
        $id = $request->route('id');
		$fts = FileTypes::find($id);
		return view('file_types.edit')->withFts($fts);
    }
	
	public function update(Request $request,$id)
	{
		$this->validate($request, [
		]);
		
		$fts = FileTypes::find($id);
		$fts->type = $request->input('type');
		//$fts->postfix = $request->input('postfix');
		$fts->description = $request->input('description');
		$fts->user = Auth::user()->name;
		$fts->save();
		return Redirect::to('file_types');
	}

}
