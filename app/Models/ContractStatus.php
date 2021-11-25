<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiResponser;

class ContractStatus extends Model
{
    use ApiResponser;
    protected $table = "contract_status";

    public function contracts()
    {
        return $this->hasMany('App\Models\Contract');
    }
    // protected $fillable = [];

    // public $timestamps = false;
}
