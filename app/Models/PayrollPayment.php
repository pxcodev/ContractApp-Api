<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiResponser;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PayrollPayment extends Model
{
    use ApiResponser, HasFactory;
    protected $table = "payroll_payments";

    public function paymentMethod()
    {
        return $this->belongsTo('App\Models\PaymentMethod');
    }

    public function worker()
    {
        return $this->belongsTo('App\Models\Worker');
    }

    public function contract()
    {
        return $this->belongsTo('App\Models\Contract');
    }
    // protected $fillable = [];

    // public $timestamps = false;
}
