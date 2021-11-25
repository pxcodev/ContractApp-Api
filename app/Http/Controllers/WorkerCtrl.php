<?php

namespace App\Http\Controllers;

use App\Http\Resources\WorkerResource;
use Illuminate\Http\Request;
use App\Models\Worker;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class WorkerCtrl extends Controller
{
    public function index()
    {
        try {
            // 'assistances', 'assistances.contract'
            $workerData = Worker::with(['workerType'])->where('delete', 0)->get();
            return WorkerResource::collection($workerData);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Worker::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function search($id)
    {
        try {
            $workerDataResult = Worker::findOrFail($id);
            if (!$workerDataResult) return Worker::error('Worker', 'The worker was not found', 423);
            return WorkerResource::make($workerDataResult->load(['workerType']));
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Worker::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function save(Request $request)
    {
        try {
            $workerData = new Worker();
            $workerData->names = $request->names;
            $workerData->surnames = $request->surnames;
            $workerData->identificationDocument = $request->identificationDocument;
            $workerData->gender = $request->gender;
            $workerData->nationality = $request->nationality;
            $workerData->workerAddress = $request->workerAddress;
            $workerData->phone = $request->phone;
            $workerData->registrationDate = Carbon::parse($request->registrationDate)->format('Y-m-d');
            $workerData->worker_type_id = $request->worker_type_id;
            $workerData->hourly = $request->hourly;
            $workerData->save();
            return Worker::success('Worker', 'Has been successfully registered', 200, $workerData->toArray());
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Worker::error('Internal error', $ex->getMessage(), 423);
        }

        return response()->json($request);
    }

    public function delete($id)
    {
        try {
            $workerDataResult = Worker::findOrFail($id);
            $workerDataResult->delete = 1;
            $workerDataResult->save();
            return Worker::success('Worker', 'Successfully eliminated', 200, $workerDataResult->toArray());
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Worker::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $workerDataResult = Worker::findOrFail($id);
            if ($workerDataResult->delete == 1) return Worker::error('Worker', 'It is not possible to update deleted workers', 423);
            $workerDataResult->names = $request->names;
            $workerDataResult->surnames = $request->surnames;
            $workerDataResult->identificationDocument = $request->identificationDocument;
            $workerDataResult->gender = $request->gender;
            $workerDataResult->nationality = $request->nationality;
            $workerDataResult->workerAddress = $request->workerAddress;
            $workerDataResult->phone = $request->phone;
            $workerDataResult->registrationDate = Carbon::parse($request->registrationDate)->format('Y-m-d');
            $workerDataResult->worker_type_id = $request->worker_type_id;
            $workerDataResult->hourly = $request->hourly;
            $workerDataResult->save();
            return Worker::success('Worker', 'Has been successfully updated', 200, $workerDataResult->toArray());
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Worker::error('Internal error', $ex->getMessage(), 423);
        }

        return response()->json("Update worker success");
    }

    public function trash()
    {
        try {
            $trashWorkers = Worker::with(['workerType', 'assistances', 'assistances.contract'])->where('delete', 1)->get();
            return WorkerResource::collection($trashWorkers);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Worker::error('Internal error', $ex->getMessage(), 423);
        }
    }

    public function recover($id)
    {
        try {
            $recoveredWorker = Worker::findOrFail($id);
            if ($recoveredWorker->delete == 0) return Worker::error('Worker', 'It is not possible to recover a worker that has not been deleted', 423);
            $recoveredWorker->delete = 0;
            $recoveredWorker->save();
            return Worker::success('Worker', 'Successfully recovered', 200, $recoveredWorker->toArray());
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Worker::error('Internal error', $ex->getMessage(), 423);
        }
    }
}
