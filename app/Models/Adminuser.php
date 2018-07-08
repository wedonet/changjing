<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adminuser extends Model
{
    protected $guarded = ['_token'];
    protected $table='adminusers';
    protected $primaryKey='id';
    public $timestamps=false;
}
