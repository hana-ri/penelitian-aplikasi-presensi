<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $guarded = ['id'];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id');
    }
}
