<?php

namespace App\Http\Controllers;

use App\Http\Resources\PayrollPaymentResource;
use Illuminate\Http\Request;
use App\Models\PayrollPayment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class PayrollPaymentCtrl extends Controller
{
    public function index()
    {
        try {
            $payrollPayments = PayrollPayment::with('paymentMethod', 'worker.assistances', 'contract')->where('payroll_payments.delete', '=', 0)->get();
            return PayrollPaymentResource::collection($payrollPayments);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return PayrollPayment::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function search($id)
    {
        try {
            $payment = PayrollPayment::findOrFail($id);
            return PayrollPaymentResource::make($payment->load(['worker', 'contract']));
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return PayrollPayment::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function saveBase64(Request $request)
    {
        try {
            $paymentData = new PayrollPayment();
            $destinyFolder = './upload/';
            $imageName = '';
            $receipt = 'Not applicable';
            if (gettype($request->receipt) === 'array') {
                $image = $request->receipt['base64'];  // your base64 encoded
                $ext = $request->receipt['ext'];
                $originalName = $request->receipt['name'];
                $image = str_replace('data:image/' . $ext . ';base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = Carbon::now()->timestamp . "_" . $originalName . '.' . $ext;
                !file_exists($destinyFolder) ? File::makeDirectory($destinyFolder) : false;
                File::put(base_path('public') . $destinyFolder . $imageName, base64_decode($image));
                $receipt = ltrim($destinyFolder, '.') . $imageName;
            }
            $paymentData->worker_id = $request->worker_id;
            $paymentData->contract_id = $request->contract_id;
            $paymentData->paidHours = $request->paidHours;
            $paymentData->amount = $request->amount;
            $paymentData->payment_method_id = $request->payment_method_id;
            $paymentData->date = Carbon::parse($request->date)->format('Y-m-d');
            $paymentData->receipt = $receipt;
            $paymentData->save();
            return PayrollPayment::success('Payroll Payment', 'Has been successfully registered', 200);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return PayrollPayment::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function delete($id)
    {
        try {
            $paymentDataResult = PayrollPayment::findOrFail($id);

            if ($paymentDataResult->delete !== 0) return PayrollPayment::error('PayrollPayment', 'PayrollPayment was previously eliminated', 423);

            if ($paymentDataResult->receipt !== 'Not applicable') {
                $routeFile = base_path('public') . $paymentDataResult->receipt;
                $nameFile = explode('/', $paymentDataResult->receipt)[2];
                $destinyFolder = './trash/';
                !file_exists($destinyFolder) ? File::makeDirectory($destinyFolder) : false;
                File::move($routeFile, $destinyFolder . $nameFile);
                $paymentDataResult->receipt = ltrim($destinyFolder, '.') . $nameFile;
            }


            $paymentDataResult->delete = 1;
            $paymentDataResult->save();
            return PayrollPayment::success('Payroll Payment', 'You have been successfully deleted', 200);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return PayrollPayment::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $paymentDataResult = PayrollPayment::findOrFail($id);
            $destinyFolder = './upload/';
            $imageName = '';
            $receipt = $request->receipt;
            if ($paymentDataResult->delete !== 0) return PayrollPayment::error('PayrollPayment', 'it is not possible to update a deleted payment', 423);

            if ($request->receipt === 'Not applicable' && $paymentDataResult->receipt !== 'Not applicable') {
                $routeFile = base_path('public') . $paymentDataResult->receipt;
                file_exists($routeFile) ? unlink($routeFile) : false;
            }

            if (gettype($request->receipt) === 'array') {

                $routeFile = base_path('public') . $paymentDataResult->receipt;
                file_exists($routeFile) ? unlink($routeFile) : false;

                $image = $request->receipt['base64'];  // your base64 encoded
                $ext = $request->receipt['ext'];
                $originalName = $request->receipt['name'];
                $image = str_replace('data:image/' . $ext . ';base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = Carbon::now()->timestamp . "_" . $originalName . '.' . $ext;
                !file_exists($destinyFolder) ? File::makeDirectory($destinyFolder) : false;
                File::put(base_path('public') . $destinyFolder . $imageName, base64_decode($image));
                $receipt = ltrim($destinyFolder, '.') . $imageName;
            };

            $paymentDataResult->worker_id = $request->worker_id;
            $paymentDataResult->contract_id = $request->contract_id;
            $paymentDataResult->paidHours = $request->paidHours;
            $paymentDataResult->amount = $request->amount;
            $paymentDataResult->payment_method_id = $request->payment_method_id;
            $paymentDataResult->receipt = $receipt;
            $paymentDataResult->save();
            return PayrollPayment::success('Payroll Payment', 'Update data success', 200, $paymentDataResult->toArray());
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return PayrollPayment::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function trash()
    {
        try {
            $paymentsData = PayrollPayment::with(['worker', 'contract'])->where('delete', 1)->get();
            return PayrollPaymentResource::collection($paymentsData);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return PayrollPayment::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function recover($id)
    {
        try {
            $paymentDataResult = PayrollPayment::findOrFail($id);
            if ($paymentDataResult->delete == 0) return PayrollPayment::error('PayrollPayment', 'It is not possible to recover a payment that is not delete', 423);
            if ($paymentDataResult->receipt !== 'Not applicable') {
                $routeFile = base_path('public') . $paymentDataResult->receipt;
                $nameFile = explode('/', $paymentDataResult->receipt)[2];
                $destinyFolder = './upload/';
                !file_exists($destinyFolder) ? File::makeDirectory($destinyFolder) : false;
                File::move($routeFile, $destinyFolder . $nameFile);
                $paymentDataResult->receipt = ltrim($destinyFolder, '.') . $nameFile;
            }
            $paymentDataResult->delete = 0;
            $paymentDataResult->save();
            return PayrollPaymentResource::make($paymentDataResult->load('contract'));
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return PayrollPayment::error('Internal error', $ex->getMessage(), 423);
        }
    }
}
