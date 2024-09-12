<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appendix extends Model
{
    protected $guarded = [
        'id'
    ];

    protected $table = 'appendixes';

    public function attendance()
    {
        return $this->belongsTo(Attendance::class, 'attendance_id');
    }
}
