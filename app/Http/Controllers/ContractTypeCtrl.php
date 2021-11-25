<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContractTypeResource;
use Illuminate\Http\Request;
use App\Models\ContractType;
use Illuminate\Support\Facades\Log;

class ContractTypeCtrl extends Controller
{
    public function index()
    {
        try {
            $contractTypesData = ContractType::all();
            // $contractTypesData->load('contracts');
            if (count($contractTypesData) == 0) return ContractType::error('Contract Types', 'No registered types', 200);
            return ContractTypeResource::collection($contractTypesData);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return ContractType::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function search($id)
    {
        try {
            $contractTypeDataResult = ContractType::findOrFail($id);
            if (!$contractTypeDataResult) return ContractType::error('Contract Types', 'No type found', 200);
            return ContractTypeResource::make($contractTypeDataResult->load('contracts'));
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return ContractType::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function save(Request $request)
    {
        try {
            $contractTypeDataResult = new ContractType();
            $contractTypeDataResult->name = $request->name;
            $contractTypeDataResult->save();
            return ContractType::success('Contract Types', 'Has been successfully registered', 200, $contractTypeDataResult->toArray());
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return ContractType::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function delete($id)
    {
        try {
            $contractTypeDataResult = ContractType::findOrFail($id);
            if (!$contractTypeDataResult) return ContractType::error('Contract Types', 'No type found', 200);
            $contractTypeDataResult->delete();
            return ContractType::success('Contract Types', 'Type was successfully removed', 200, $contractTypeDataResult->toArray());
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return ContractType::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $contractTypeDataResult = ContractType::find($id);
            if (!$contractTypeDataResult) return ContractType::error('Contract Types', 'No type found', 200);
            $contractTypeDataResult->name = $request->name;
            $contractTypeDataResult->save();
            return ContractType::success('Contract Types', 'Ha sido actualizado satisfactoriamente', 200, $contractTypeDataResult->toArray());
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return ContractType::error('Internal error', $ex->getMessage(), 423);
        }
    }
}
