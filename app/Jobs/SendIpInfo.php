<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\IpInfoSQL;
use Cache;

class SendIpInfo extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    protected $ip,$sn;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($ip,$sn)
    {
        $this->ip = $ip;
	$this->sn = $sn;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
	$ak = "H0m72fSsSclVU4XR1cPFCxKVpB5xUvZE";
        $newIP = $this->ip;
	$newSN = $this->sn;
	///cache使用
	/*
	$cacheSN =  Cache::get('key');
	if($cacheIP != null) {
		$content = file_get_contents("http://api.map.baidu.com/location/ip?&ak=".$ak."&coor=bd09ll");//mine di精度
		$json = json_decode($content);
		IpInfoSQL::ip_info_add_low($json,$newSN);
	}
	else{
		
		echo "111";
	}
	*/
	//$content = file_get_contents("http://api.map.baidu.com/highacciploc/v1?qcip=".$newIP."&ak=".$ak."&extensions=1&coord=bd09ll");//高精度查询
	$content = file_get_contents("http://api.map.baidu.com/location/ip?ip=".$newIP."&ak=".$ak."&coor=bd09ll");
	$json = json_decode($content);
	IpInfoSQL::ip_info_add_low($json,$newIP,$newSN);
	//IpInfoSQL::ip_info_add($json,$newIP,$newSN);
    }
}
