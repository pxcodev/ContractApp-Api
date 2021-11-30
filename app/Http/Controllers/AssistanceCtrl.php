<?php

namespace App\Http\Controllers;

use App\Http\Resources\AssistanceResource;
use App\Http\Resources\ContractResource;
use App\Http\Resources\WorkerResource;
use Illuminate\Http\Request;
use App\Models\Assistance;
use App\Models\Contract;
use App\Models\Worker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AssistanceCtrl extends Controller
{
    public function index()
    {
        try {
            $contractAssistanceData = Assistance::with(['contract', 'contract.payments', 'worker'])->get();
            return AssistanceResource::collection($contractAssistanceData);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Assistance::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function indexDateFilter(Request $request)
    {
        try {
            // $from = date('2018-01-01');
            // $to = date('2018-05-02')
            $contractAssistanceData = Assistance::with(['contract', 'contract.payments', 'worker.payrollPayment'])
                ->whereBetween('assistanceDate', [Carbon::parse($request->from)->format('Y-m-d'), Carbon::parse($request->to)->format('Y-m-d')])->get();
            return AssistanceResource::collection($contractAssistanceData);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Assistance::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function save(Request $request)
    {
        try {
            $Assistance = new Assistance();
            $contractAssistanceFind = DB::table('assistances')
                ->where('assistances.worker_id', '=', $request->worker_id)
                ->where('assistances.contract_id', '=', $request->contract_id)
                ->where('assistances.assistanceDate', '=', Carbon::parse($request->assistanceDate)->format('Y-m-d'))
                ->get();
            if (!$contractAssistanceFind->isEmpty()) return Assistance::error('Assistance', 'Assistance was already marked', 423);
            $Assistance->worker_id = $request->worker_id;
            $Assistance->contract_id = $request->contract_id;
            $Assistance->hoursWorked = $request->hoursWorked;
            $Assistance->assistanceDate = Carbon::parse($request->assistanceDate)->format('Y-m-d');
            $Assistance->save();
            return Assistance::success('Assistance', 'Assistance was successfully marked', 200, $Assistance->toArray());
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Assistance::error('Internal error', $ex->getMessage(), 423);
        }
    }


    public function contractsAssistances()
    {
        try {
            $contractAssistances = Contract::with(['assistances.worker'])->has('assistances')->get();
            return ContractResource::collection($contractAssistances);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Contract::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function workersAssistances()
    {
        try {
            $workersAssistances = Worker::with(['assistances.contract'])->has('assistances')->get();
            return WorkerResource::collection($workersAssistances);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Worker::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function update($id, $assistance)
    {
        try {
            $Assistance = Assistance::find($id);
            $Assistance->assistance = $assistance;
            $Assistance->save();
            return Worker::success('Assistance', 'It was correctly modified', 200);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Worker::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function searchAssistancesWorker($id)
    {
        try {
            $workerAssistances = Assistance::with(['contract.contractType', 'contract.contractStatus'])->where('worker_id', $id)->get();
            return Assistance::success('Assistance', 'The Contracts/Workers relationship has been updated successfully', 200, $workerAssistances->toArray());
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Assistance::error('Internal error', $ex->getMessage(), 423);
        }
    }
    public function searchAssistancesContract($id)
    {
        try {
            $contractAssistance = Assistance::with(['worker.workerType'])->where('contract_id', $id)->get();
            return Assistance::success('Assistance', 'The Contracts/Workers relationship has been updated successfully', 200, $contractAssistance->toArray());
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Assistance::error('Internal error', $ex->getMessage(), 423);
        }
    }
}
