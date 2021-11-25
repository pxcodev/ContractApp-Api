<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ApiResponser;

class Assignment extends Model
{
    use HasFactory, ApiResponser;
    protected $table = "assignments";

    public function contract()
    {
        return $this->belongsTo('App\Models\Contract');
    }

    public function worker()
    {
        return $this->belongsTo('App\Models\Worker');
    }
    // protected $fillable = [];

    // public $timestamps = false;
}
