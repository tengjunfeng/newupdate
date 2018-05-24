<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class DevInfo extends Model
{
    protected $table='sunya_dev_info'; 

    public function sys()
    {
	 return $this->hasOne('App\FileTypes', 'code', 'T_REQ_PACK_ID');
    }
}
