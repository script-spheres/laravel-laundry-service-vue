<?php

namespace App\Models;

use Database\Factories\TimeslotFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timeslot extends Model
{
    /** @use HasFactory<TimeslotFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'start_time',
        'end_time',
        'day',
        'capacity',
    ];
}
