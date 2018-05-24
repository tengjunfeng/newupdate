<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UpgradeFile extends Model
{
    protected $table = 'upgrade_files';

    public function file_type_obj()
    {
        return $this->hasOne('App\FileTypes','code','code');
    }
}

