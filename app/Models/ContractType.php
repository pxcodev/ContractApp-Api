<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiResponser;

class ContractType extends Model
{
    use ApiResponser;
    protected $table = "contract_types";

    public function contracts()
    {
        return $this->hasMany('App\Models\Contract');
    }

    // protected $fillable = [];

    // public $timestamps = false;
}
