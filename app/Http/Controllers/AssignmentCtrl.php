<?php

namespace App\Http\Controllers;

use App\Http\Resources\AssignmentsResource;
use App\Http\Resources\ContractAssignmentResource;
use App\Http\Resources\ContractResource;
use App\Http\Resources\WorkerAssignmentResource;
use App\Http\Resources\WorkerResource;
use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Contract;
use App\Models\Worker;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;

class AssignmentCtrl extends Controller
{
    public function index()
    {
        try {
            $contractAssignment = Assignment::with(['contract', 'worker'])->where('assignments.delete', '=', 0)->get();
            return AssignmentsResource::collection($contractAssignment);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Assignment::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function search($id)
    {
        try {
            $contractAssignment = Assignment::findOrFail($id);
            return AssignmentsResource::make($contractAssignment->load(['contract', 'worker']));
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Assignment::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function searchAvailableWorkers($id)
    {
        try {
            $contractAssignment = Contract::findOrFail($id)->load(['assignments.worker']);

            $workersTrue = $contractAssignment->assignments->where('delete', 0)->pluck('worker');
            $workersTrue->map(fn ($worker) => $worker['checked'] = true);

            $exception = $workersTrue->pluck('id');

            $availableForAssignment = Worker::whereNotIn('id', $exception)->where('delete', '=', 0)->get();
            $availableForAssignment->map(fn ($worker) => $worker['checked'] = false);


            return WorkerAssignmentResource::collection($availableForAssignment->merge($workersTrue)->sortBy('id'));
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Assignment::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function searchAvailableContracts($id)
    {
        try {
            $Assignment = Worker::findOrFail($id)->load(['assignments.contract']);

            $contractTrue = $Assignment->assignments->where('delete', 0)->pluck('contract');
            $contractTrue->map(fn ($contract) => $contract['checked'] = true);

            $exception = $contractTrue->pluck('id');

            $availableForAssignment = Contract::whereNotIn('id', $exception)->where('delete', '=', 0)->get();
            $availableForAssignment->map(fn ($contract) => $contract['checked'] = false);
            return ContractAssignmentResource::collection($availableForAssignment->merge($contractTrue)->sortBy('id'));
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Assignment::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function save(Request $request)
    {
        try {
            $ContractAssignment = new Assignment();
            $contractsWorkersResult = Assignment::where('assignments.contract_id', '=', $request->contract_id)
                ->where('assignments.worker_id', '=', $request->worker_id)
                ->get();
            if ($contractsWorkersResult->isEmpty()) {
                $ContractAssignment->contract_id = $request->contract_id;
                $ContractAssignment->worker_id = $request->worker_id;
                $ContractAssignment->save();
                return Assignment::success('Assignment', 'The Contracts/Workers relationship has been successfully registered', 200, $ContractAssignment->toArray());
            }
            $ContractAssignmentFind = Assignment::find($contractsWorkersResult[0]->id);
            $ContractAssignmentFind->delete = !$ContractAssignmentFind->delete;
            $ContractAssignmentFind->save();
            return Assignment::success('Assignment', 'The Contracts/Workers relationship has been updated successfully', 200, $ContractAssignmentFind->toArray());
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Assignment::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function contractsAssignments()
    {
        try {
            $contractsAssignments = Contract::with(['assignments.worker.payrollPayment'])->whereHas('assignments', function (Builder $query) {
                $query->where('delete', '=', 0);
            })->get();
            return ContractResource::collection($contractsAssignments);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Contract::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function workersAssignments()
    {
        try {
            $workersAssignments = Worker::with(['assignments.contract.payrollPayment'])->whereHas('assignments', function (Builder $query) {
                $query->where('delete', '=', 0);
            })->get();
            return WorkerResource::collection($workersAssignments);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Worker::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function searchAssignmentsWorker($id)
    {
        try {
            $workerAssignment = Assignment::with(['contract.contractType', 'contract.contractStatus', 'contract.assistances', 'contract.payrollPayment'])->where('worker_id', $id)->get();
            return Assignment::success('Assignment', 'The Contracts/Workers relationship has been updated successfully', 200, $workerAssignment->toArray());
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Assignment::error('Internal error', $ex->getMessage(), 423);
        }
    }
    public function searchAssignmentsContract($id)
    {
        try {
            $contractAssignment = Assignment::with(['worker.workerType', 'worker.assistances', 'worker.payrollPayment'])->where('contract_id', $id)->get();
            return Assignment::success('Assignment', 'The Contracts/Workers relationship has been updated successfully', 200, $contractAssignment->toArray());
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Assignment::error('Internal error', $ex->getMessage(), 423);
        }
    }
}
