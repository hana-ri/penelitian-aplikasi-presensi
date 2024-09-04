<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Meeting extends Model
{
    protected $guarded = ['id'];

    public function getStartTimeAttribute($value)
    {
        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    public function getEndTimeAttribute($value)
    {
        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    public function classroom() {
        return $this->belongsTo(Classroom::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
