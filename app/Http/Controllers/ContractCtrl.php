<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContractResource;
use Illuminate\Http\Request;
use App\Models\Contract;
use App\Models\ContractType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ContractCtrl extends Controller
{

    public function index()
    {
        try {
            // 'assistances', 'assistances.worker'
            $contractsData = Contract::with(['contractType', 'contractStatus'])->where('delete', 0)->get();
            return ContractResource::collection($contractsData);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Contract::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function search($id)
    {
        try {
            $contract = Contract::findOrFail($id);
            return new ContractResource($contract->load('contractType'));
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Contract::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function save(Request $request)
    {
        try {
            $contractData = new Contract();
            $contractData->name = $request->name;
            $contractData->contractAddress = $request->contractAddress;
            $contractData->contract_type_id = $request->contract_type_id;
            $contractData->startDate = Carbon::parse($request->startDate)->format('Y-m-d');
            $contractData->endDate = Carbon::parse($request->endDate)->format('Y-m-d');
            $contractData->totalCost = $request->totalCost;
            $contractData->contract_status_id = $request->contract_status_id;
            $contractData->save();
            return Contract::success('Contract', 'Has been successfully registered', 200, $contractData->toArray());
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Contract::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function delete($id)
    {
        try {
            $contractDataResult = Contract::findOrFail($id);
            if ($contractDataResult->delete === 1) return Contract::error('Contract', 'Previously deleted', 200);
            $contractDataResult->delete = 1;
            $contractDataResult->save();
            return Contract::success('Contract', 'Successfully eliminated', 200, $contractDataResult->toArray());
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Contract::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $contractDataResult = Contract::find($id);
            if ($contractDataResult->delete == 1) return response()->json("It is not possible to update deleted contracts");
            $contractDataResult->name = $request->name;
            $contractDataResult->contractAddress = $request->contractAddress;
            $contractDataResult->contract_type_id = $request->contract_type_id;
            $contractDataResult->startDate = Carbon::parse($request->startDate)->format('Y-m-d');
            $contractDataResult->endDate = Carbon::parse($request->endDate)->format('Y-m-d');;
            $contractDataResult->totalCost = $request->totalCost;
            $contractDataResult->contract_status_id = $request->contract_status_id;
            $contractDataResult->save();
            return Contract::success('Contract', 'Successfully updated', 200);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Contract::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function trash()
    {
        try {
            $trashContracts = Contract::with(['contractType', 'contractStatus'])->where('delete', 1)->get();
            return ContractResource::collection($trashContracts);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Contract::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function recover($id)
    {
        try {
            $contractDataResult = Contract::findOrFail($id);
            if ($contractDataResult->delete == 0) return Contract::error('Contract', 'It is not possible to recover a contract that has not been deleted', 200);
            $contractDataResult->delete = 0;
            $contractDataResult->save();
            return Contract::success('Contract', 'Successfully recovered', 200, $contractDataResult->toArray());
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Contract::error('Internal error', $ex->getMessage(), 423);
        }
    }
}
