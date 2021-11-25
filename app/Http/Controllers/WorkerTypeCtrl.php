<?php

namespace App\Http\Controllers;

use App\Http\Resources\WorkerTypeResource;
use Illuminate\Http\Request;
use App\Models\WorkerType;
use Illuminate\Support\Facades\Log;

class WorkerTypeCtrl extends Controller
{
    public function index()
    {
        try {
            $workerTypesData = WorkerType::all();
            if (count($workerTypesData) == 0) return "No registered workers types";
            return WorkerTypeResource::collection($workerTypesData);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return WorkerType::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function search($id)
    {
        try {
            $workerTypeDataResult = WorkerType::find($id);
            if (!$workerTypeDataResult) return "No worker type found";
            return WorkerTypeResource::make($workerTypeDataResult);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return WorkerType::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function save(Request $request)
    {
        try {
            $workerTypeDataResult = new WorkerType();
            $workerTypeDataResult->name = $request->name;
            $workerTypeDataResult->save();
            return WorkerType::success('Worker Type', 'Has been successfully registered', 200, $workerTypeDataResult->toArray());
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return WorkerType::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function delete($id)
    {
        try {
            $workerTypeDataResult = WorkerType::find($id);
            if (!$workerTypeDataResult) WorkerType::error('Worker Type', 'No worker type found', 423);
            $workerTypeDataResult->delete();
            return WorkerType::success('Worker Type', 'Has been successfully removed', 200);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return WorkerType::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $workerTypeDataResult = WorkerType::find($id);
            if (!$workerTypeDataResult) WorkerType::error('Worker Type', 'No worker type found', 423);
            $workerTypeDataResult->name = $request->name;
            $workerTypeDataResult->save();
            return WorkerType::success('Worker Type', 'Has been successfully updated', 200, $workerTypeDataResult->toArray());
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return WorkerType::error('Internal error', $ex->getMessage(), 423);
        }
    }
}
