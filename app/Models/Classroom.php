<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classroom extends Model
{
    protected
    $guarded = ['id'],
    $with = ['meetings', 'ownUser'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getStartTimeAttribute($value)
    {
        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    public function getEndTimeAttribute($value)
    {
        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    public function users()
    {
        return $this->belongsToMany(MoodleUser::class, 'user_classroom', 'classroom_id', 'user_id');
    }

    public function meetings() : HasMany {
        return $this->hasMany(Meeting::class);
    }

    public function ownUser() {
        return $this->belongsTo(MoodleUser::class, 'user_id');
    }
}
