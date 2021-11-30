<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentMethodResource;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentMethodCtrl extends Controller
{
    public function index()
    {
        try {
            $paymentMethods = PaymentMethod::all();
            if (count($paymentMethods) == 0) return PaymentMethod::error('Payment Methods', 'No registered Methods', 200);
            return PaymentMethodResource::collection($paymentMethods);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return PaymentMethod::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function search($id)
    {
        try {
            $paymentMethodResult = PaymentMethod::findOrFail($id);
            if (!$paymentMethodResult) return PaymentMethod::error('Payment Methods', 'No method found', 200);
            return PaymentMethodResource::make($paymentMethodResult->load('payrollPayment'));
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return PaymentMethod::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function save(Request $request)
    {
        try {
            $paymentMethodResult = new PaymentMethod();
            $paymentMethodResult->name = $request->name;
            $paymentMethodResult->save();
            return PaymentMethod::success('Payment Methods', 'Has been successfully registered', 200, $paymentMethodResult->toArray());
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return PaymentMethod::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function delete($id)
    {
        try {
            $paymentMethodResult = PaymentMethod::findOrFail($id);
            if (!$paymentMethodResult) return PaymentMethod::error('Payment Methods', 'No method found', 200);
            $paymentMethodResult->delete();
            return PaymentMethod::success('Payment Methods', 'Type was successfully removed', 200, $paymentMethodResult->toArray());
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return PaymentMethod::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $paymentMethodResult = PaymentMethod::find($id);
            if (!$paymentMethodResult) return PaymentMethod::error('Payment Methods', 'No method found', 200);
            $paymentMethodResult->name = $request->name;
            $paymentMethodResult->save();
            return PaymentMethod::success('Payment Methods', 'Ha sido actualizado satisfactoriamente', 200, $paymentMethodResult->toArray());
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return PaymentMethod::error('Internal error', $ex->getMessage(), 423);
        }
    }
}
