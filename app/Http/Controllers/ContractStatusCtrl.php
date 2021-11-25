<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContractStatusResource;
use Illuminate\Http\Request;
use App\Models\ContractStatus;
use Illuminate\Support\Facades\Log;

class ContractStatusCtrl extends Controller
{

    public function index()
    {
        try {
            $contractStatusData = ContractStatus::all();
            if (count($contractStatusData) == 0) return ContractStatus::error('Contract Status', 'No statuses registered', 200);
            return ContractStatusResource::collection($contractStatusData);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return ContractStatus::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function search($id)
    {
        try {
            $contractStatusDataResult = ContractStatus::findOrFail($id);
            if (!$contractStatusDataResult) return ContractStatus::error('Contract Status', 'No status found', 200);
            return response()->json($contractStatusDataResult->load('contracts'));
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return ContractStatus::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function save(Request $request)
    {
        try {
            $contractStatusDataResult = new ContractStatus();
            $contractStatusDataResult->name = $request->name;
            $contractStatusDataResult->save();
            return ContractStatus::success('Contract Status', 'Has been successfully registered', 200, $contractStatusDataResult->toArray());
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return ContractStatus::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function delete($id)
    {
        try {
            $contractStatusDataResult = ContractStatus::find($id);
            if (!$contractStatusDataResult) return ContractStatus::error('Contract Status', 'No status found', 200);
            $contractStatusDataResult->delete();
            return ContractStatus::success('Contract Status', 'Has been successfully removed', 200, $contractStatusDataResult->toArray());
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return ContractStatus::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $contractStatusDataResult = ContractStatus::find($id);
            if (!$contractStatusDataResult) return ContractStatus::error('Contract Status', 'No status found', 200);
            $contractStatusDataResult->name = $request->name;
            $contractStatusDataResult->save();
            return ContractStatus::success('Contract Status', 'Has been successfully updated', 200, $contractStatusDataResult->toArray());
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return ContractStatus::error('Internal error', $ex->getMessage(), 423);
        }
    }
}
