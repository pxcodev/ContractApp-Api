<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentResource;
use Illuminate\Http\Request;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class PaymentCtrl extends Controller
{

    public function index()
    {
        try {
            $payments = Payment::with('contract')->where('payments.delete', '=', 0)->get();
            return PaymentResource::collection($payments);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Payment::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function search($id)
    {
        try {
            $payment = Payment::findOrFail($id);
            return PaymentResource::make($payment->load('contract'));
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Payment::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function save(Request $request)
    {
        try {
            $paymentData = new Payment();
            $destinyFolder = './upload/';
            $newName = '';
            if ($request->hasFile('receipt')) {
                $originalName = $request->file('receipt')->getClientOriginalName();
                $newName = Carbon::now()->timestamp . "_" . $originalName;
                $request->file('receipt')->move($destinyFolder, $newName);
            }
            $paymentData->contract_id = $request->contract_id;
            $paymentData->date = Carbon::parse($request->paymentDate)->format('Y-m-d');
            $paymentData->receipt = ltrim($destinyFolder, '.') . $newName;
            $paymentData->amount = $request->amount;
            $paymentData->save();
            return Payment::success('Payment', 'Has been successfully registered', 200, $paymentData->toArray());
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Payment::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function saveBase64(Request $request)
    {
        try {
            $paymentData = new Payment();
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
                File::put(base_path('public') . ltrim($destinyFolder, '.') . $imageName, base64_decode($image));
                $receipt = ltrim($destinyFolder, '.') . $imageName;
            }
            $paymentData->contract_id = $request->contract_id;
            $paymentData->date = Carbon::parse($request->date)->format('Y-m-d');
            $paymentData->receipt = $receipt;
            $paymentData->amount = $request->amount;
            $paymentData->save();
            return Payment::success('Payment', 'Has been successfully registered', 200);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Payment::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function delete($id)
    {
        try {
            $paymentDataResult = Payment::findOrFail($id);

            if ($paymentDataResult->delete !== 0) return Payment::error('Payment', 'Payment was previously eliminated', 423);

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
            return Payment::success('Payment', 'You have been successfully deleted', 200);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Payment::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $paymentDataResult = Payment::findOrFail($id);
            $destinyFolder = './upload/';
            $imageName = '';
            $receipt = $request->receipt;
            if ($paymentDataResult->delete !== 0) return Payment::error('Payment', 'it is not possible to update a deleted payment', 423);

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
                File::put(base_path('public') . ltrim($destinyFolder, '.') . $imageName, base64_decode($image));
                $receipt = ltrim($destinyFolder, '.') . $imageName;
            };

            $paymentDataResult->contract_id = $request->contract_id;
            $paymentDataResult->receipt = $receipt;
            $paymentDataResult->date = Carbon::parse($request->date)->format('Y-m-d');
            $paymentDataResult->save();
            return Payment::success('Payment', 'Update data success', 200, $paymentDataResult->toArray());
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Payment::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function trash()
    {
        try {
            $paymentsData = Payment::with('contract')->where('delete', 1)->get();
            return PaymentResource::collection($paymentsData);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Payment::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function recover($id)
    {
        try {
            $paymentDataResult = Payment::findOrFail($id);
            if ($paymentDataResult->delete == 0) return Payment::error('Payment', 'It is not possible to recover a payment that is not delete', 423);
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
            return PaymentResource::make($paymentDataResult->load('contract'));
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Payment::error('Internal error', $ex->getMessage(), 423);
        }
    }
}
