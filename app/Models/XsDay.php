<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class XsDay extends Model
{
    protected $table = 'xs_day';
    protected $primaryKey = 'id';

    public function xsDetails()
    {
        return $this->hasMany('App\Models\XsDetail');
    }
}
