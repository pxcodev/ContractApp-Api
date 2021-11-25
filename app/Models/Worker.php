<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ApiResponser;

class Worker extends Model
{
    use HasFactory, ApiResponser;
    protected $table = "workers";

    public function workerType()
    {
        return $this->belongsTo('App\Models\WorkerType');
    }

    public function assistances()
    {
        return $this->hasMany('App\Models\Assistance');
    }

    public function assignments()
    {
        return $this->hasMany('App\Models\Assignment');
    }

    // protected $fillable = [];

    // public $timestamps = false;
}
