<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiResponser;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory, ApiResponser;
    protected $table = "payments";

    public function contract()
    {
        return $this->belongsTo('App\Models\Contract');
    }
    // protected $fillable = [];

    // public $timestamps = false;
}
