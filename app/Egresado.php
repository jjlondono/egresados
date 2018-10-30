<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Egresado extends Model
{

	protected $table = 'egresados';
    //relacion
    public function user(){
    	return $this->belongsTo('App\User', 'admin_id');
    }
}
