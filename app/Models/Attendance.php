<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $guarded = ['id'];

    public $with = ['appendices'];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }


    public function appendices()
    {
        return $this->hasMany(Appendix::class, 'attendance_id');
    }
}
