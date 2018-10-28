<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Egresado extends Model
{

	protected $table = 'egresados';
    //relacion
    public function administrador(){
    	return $this->belongsTo('App\Administrador', 'admin_id');
    }
}
