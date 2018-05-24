<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\DevInfo;
use App\IpInfo;
use App\CompanyUpdate;

class IpInfoSQL extends Model
{
	public static function ip_info_insert($ip,$action,$sys_id,$usr_agt,$sn) {
		
		$time = date("Y-m-d H:i:s",time());
		
		$update_info = new DevInfo();

		$update_info->T_REQ_TYPE_ID = $action;
		$update_info->T_REQ_PACK_ID = $sys_id;
		$update_info->T_DEVICE_IP = $ip;
		$update_info->version = $usr_agt;
		$update_info->T_DEVICE_SN = $sn;
		
		if(strlen($sn)==29){
			$oem_code =  substr($sn,0,1);
			$cps = CompanyUpdate::where('code',$oem_code)->first();
			if(isset($cps)){
				$oem_name = $cps->name;	
			}
			else{
				$oem_name = $oem_code;
			}		
		}
		else{
			$oem_code = '0';
			$oem_name = '虚拟防火墙';
		}
		$update_info->oem_code = $oem_code;
		$update_info->oem_name = $oem_name;
		/*
		$oem_code =  substr($sn,0,1);
		$cps = CompanyUpdate::where('code',$oem_code)->first();
		$update_info->oem_code = $oem_code;
		$update_info->oem_name = $cps->name;
		*/
		if( !is_null(DB::table('sunya_ip_info')->where('sn' ,$sn)->first()) ){			
			$ip_info = IpInfo::where('sn',$sn)->update([ 'updated_at'=>$time,'dev_ip'=>$ip,'version'=>$usr_agt]);
		}
		else{
			$ip_info = new IpInfo();
			$ip_info->sn = $sn;
			$ip_info->dev_ip = $ip;
			$ip_info->oem = $oem_name;
			$ip_info->version = $usr_agt;
			$ip_info->save();
		}
		$update_info->created_at = $time;
		$update_info->updated_at = $time;
		$update_info->save();

		 
	}
	public static function ip_info_add_low($ip_json,$ip,$sn) {
		$ip_status = $ip_json->{'status'};
		if($ip_status == 0){			
			$ip_province = $ip_json->{'content'}->{'address_detail'}->{'province'};
			$ip_city = $ip_json->{'content'}->{'address_detail'}->{'city'};
			$ip_lat = $ip_json->{'content'}->{'point'}->{'y'};
			$ip_lng = $ip_json->{'content'}->{'point'}->{'x'};
		
			$ip_info = IpInfo::where(['sn'=>$sn,'dev_ip'=>$ip])->update(['country'=> '中国','province' => $ip_province,'city'=> $ip_city,'latitude'=> $ip_lat,'longitude' => $ip_lng]);
			$update_info = DevInfo::where(['T_DEVICE_SN'=>$sn,'T_DEVICE_IP'=>$ip])->update(['country'=> '中国','province' => $ip_province,'city'=> $ip_city,'latitude'=> $ip_lat,'longitude' => $ip_lng]);			 
		}
		else{
			$ip_info = IpInfo::where(['sn'=>$sn,'dev_ip'=>$ip])->update(['country'=> 'Abroad']);
			$update_info = DevInfo::where(['T_DEVICE_SN'=>$sn,'T_DEVICE_IP'=>$ip])->update(['country'=> 'Abroad']);
		}
	}
	
	public static function ip_info_add($ip_json,$ip,$sn) {
				
		$ip_country = $ip_json->{'content'}->{'address_component'}->{'country'};
		$ip_province = $ip_json->{'content'}->{'address_component'}->{'province'};
		$ip_city = $ip_json->{'content'}->{'address_component'}->{'city'};
		$ip_lat = $ip_json->{'content'}->{'location'}->{'lat'};
		$ip_lng = $ip_json->{'content'}->{'location'}->{'lng'};
		
		$ip_info = IpInfo::where(['sn'=>$sn,'dev_ip'=>$ip])->update(['country'=> $ip_country,'province' => $ip_province,'city'=> $ip_city,'latitude'=> $ip_lat,'longitude' => $ip_lng]);
		$update_info = DevInfo::where(['T_DEVICE_SN'=>$sn,'T_DEVICE_IP'=>$ip])->update(['country'=> $ip_country,'province' => $ip_province,'city'=> $ip_city,'latitude'=> $ip_lat,'longitude' => $ip_lng]);
		 
	}
}
