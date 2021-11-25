<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ApiResponser;

class Contract extends Model
{
    use HasFactory, ApiResponser;
    protected $table = "contracts";

    public function contractType()
    {
        return $this->belongsTo('App\Models\ContractType');
    }

    public function contractStatus()
    {
        return $this->belongsTo('App\Models\ContractStatus');
    }

    public function assistances()
    {
        return $this->hasMany('App\Models\Assistance');
    }

    public function assignments()
    {
        return $this->hasMany('App\Models\Assignment');
    }

    public function payments()
    {
        return $this->hasMany('App\Models\Payment');
    }

    // protected $fillable = [];

    // public $timestamps = false;
}
