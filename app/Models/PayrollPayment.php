<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiResponser;

class PayrollPayment extends Model
{
    use ApiResponser;
    protected $table = "payroll_payment";

    // protected $fillable = [];

    // public $timestamps = false;
}
