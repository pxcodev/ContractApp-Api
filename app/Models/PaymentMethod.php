<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    public function payrollPayment()
    {
        return $this->hasMany('App\Models\PayrollPayment');
    }
}
