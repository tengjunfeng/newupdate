<?php

namespace App\Http\Controllers\Update;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\DevInfo;
use App\IpInfo;
use App\FileTypes;
use App\UpgradeFile;
use Input,Redirect,Auth,DB;
use Zhuzhichao\IpLocationZh\Ip;
use App\CompanyUpdate;
use GeoIp2\Database\Reader;
use App\IpInfoSQL;
use App\Jobs\SendIpInfo;
use Storage,Queue,Cache;

class UpdateController extends Controller
{
    public function index(Request $request)
	{
		$sn_url_list = ['100OP-8D29S-20005-H0H56-3006F','100OP-8D35M-2000L-H0H56-315GL','100OP-8D35M-2000L-H0H56-3168D','100OP-8D35M-2000L-H0H56-317E7','100OP-8D35M-2000L-H0H56-30J09','100OP-8D35M-2000L-H0H56-3186F','100OP-8D35M-2000L-H0H56-316IJ','100OP-8D35M-2000L-H0H56-30JGT','100OP-8D35M-2000L-H0H56-3180H','100OP-8D35M-2000L-H0H56-31623','100OP-8D29S-20005-H0H56-3006F'];
		
		//飞利信APP库
		$flx_url_list = ['d58c70fd38f0fa9ad152a60d91d73741f6524c91'];
		
		$update_list = array();
		
		$update_list["action"] = $request->input('action');
		
		$update_list["CurrentVersion"] = $request->input('CurrentVersion');
		$update_list["DestVersion"] = $request->input('DestVersion');
		$update_list["PackFileName"] = $request->input('PackFileName');
		$update_list["sn"] = $request->input('sn');
		//缓存SN
		/*
		$kname="key";
		Cache::put($kname, $update_list["sn"], 5);
		*/
		$time = date("Y-m-d H:i:s",time());

		$update_server =array();
		$update_server["REMOTE_ADDR"] = $_SERVER['REMOTE_ADDR'];
		$update_server["REMOTE_PORT"] = $_SERVER['REMOTE_PORT'];
		$update_server["SERVER_ADDR"] = $_SERVER['SERVER_ADDR'];
		$update_server["HTTP_USER_AGENT"] = $_SERVER['HTTP_USER_AGENT'];
		
		$sys_code = FileTypes::lists('code');
		$sys_code= json_decode( json_encode( $sys_code),true);
		
		//URL库区分
		if($request->input('SystemID') == 1588){
			
			$update_list["SystemID"]=1536;
		}
		elseif($request->input('SystemID') == 1589){
			
			$update_list["SystemID"]=1537;
		}
		else{
			$update_list["SystemID"] = $request->input('SystemID');
		}		

		
		
		
		
		if(in_array($update_list["sn"],$sn_url_list)){
			
			if($request->input('SystemID') == 1537){		
				$update_list["SystemID"]=1538;
			}
			else{
				$update_list["SystemID"] = $request->input('SystemID');
			} 
		}
		/* if($request->input('SystemID') == 1539){
			
			$update_list["SystemID"]=1539;
		} */
		//飞利信APP库
		if($request->input('SystemID') ==1560){
			if(in_array($update_list["sn"],$flx_url_list)){
				$update_list["SystemID"]=1560;	
			}else{
				$update_list["SystemID"] = 0;
			}	
		}
		
		
		//var_dump($update_list["SystemID"]);
		
		if( !in_array($update_list["SystemID"],$sys_code) ){
			exit (0);
		}
		
		if(isset($update_server["HTTP_USER_AGENT"])){
			//var_dump($update_server["HTTP_USER_AGENT"]) ;
			
			if(strstr($update_server["HTTP_USER_AGENT"],'adc client 3.0')){
				$update_server["HTTP_USER_AGENT"]='1.0';
			}
			
			elseif(strstr($update_server["HTTP_USER_AGENT"],"updated ")){
				$update_server["HTTP_USER_AGENT"] = substr($update_server["HTTP_USER_AGENT"], strpos( $update_server["HTTP_USER_AGENT"],"updated ")+strlen("updated "), strlen($update_server["HTTP_USER_AGENT"])) ;
				//echo $update_server["HTTP_USER_AGENT"];
			}
			else{
				$update_server["HTTP_USER_AGENT"]=' ';
			}
			
		}
/*	
		if( strlen($update_list["sn"]) !=29){
			exit (0);
		}
*/
		$file_list = "";
	
		if( $update_list["action"] == 1){
				$update_version = UpgradeFile::where('code',$update_list["SystemID"])->where('end_version','>',$update_list["CurrentVersion"])->orderBy('start_version')->lists('name');
				$update_version = json_decode( json_encode( $update_version),true);	
				$file_list = implode(":",$update_version);					
				if($file_list != ''){
					$file_list .="::";
					echo $file_list;
				}							
		}
		

		if($update_list["action"] == 2){			
			$sys_info = FileTypes::where('code',$update_list["SystemID"])->first();				
			$sys_folder = $sys_info->folder;
			$update_path = storage_path().'/app/UpdatePacket/'.$sys_folder.'/'.$update_list["PackFileName"];
			if( is_file($update_path) ){
				$pkg_content = file_get_contents( $update_path );
				header('Content-Length: ' . strlen( $pkg_content ));
				echo $pkg_content;
			}			
		}
		
		if (isset($update_list["sn"])&& $update_list["sn"]!=''){
			IpInfoSQL::ip_info_insert($update_server["REMOTE_ADDR"],$update_list["action"],$update_list["SystemID"],$update_server["HTTP_USER_AGENT"],$update_list["sn"]);
		}

		$jobs = (new SendIpInfo($update_server["REMOTE_ADDR"],$update_list["sn"]))->delay(5);
		$json_value = $this->dispatch($jobs);
	}
}
