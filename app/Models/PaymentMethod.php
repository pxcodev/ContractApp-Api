<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiResponser;

class PaymentMethod extends Model
{
    use ApiResponser;
    public function payrollPayment()
    {
        return $this->hasMany('App\Models\PayrollPayment');
    }
}
