<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ApiResponser;

class WorkerType extends Model
{
    use HasFactory, ApiResponser;
    protected $table = "worker_types";

    public function workers()
    {
        return $this->hasMany('App\Models\Worker');
    }

    // protected $fillable = [];

    // public $timestamps = false;
}
