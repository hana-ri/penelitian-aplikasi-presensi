<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

class MoodleUser extends Authenticatable
{
    protected $connection = 'moodle';
    protected $table = 'mdl_user';
    protected $primaryKey = 'id';

    protected $fillable = [
        'username', 'password', 'email', 'firstname', 'lastname'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $with = [
        'AttendanceInformation'
    ];

    public function getFullNameAttribute()
    {
       return $this->firstname . ' ' . $this->lastname;
    }

    // Relasi ke tabel role_assignments
    public function roleAssignments()
    {
        return $this->hasMany(RoleAssignment::class, 'user_id', 'id');
    }

    // Mengambil semua role yang terkait dengan user melalui role_assignments
    public function roles()
    {
        return $this->hasManyThrough(Role::class, RoleAssignment::class, 'userid', 'id', 'id', 'roleid');
    }

    // Mengambil semua context yang terkait dengan user melalui role_assignments
    public function contexts()
    {
        return $this->hasManyThrough(Context::class, RoleAssignment::class, 'userid', 'id', 'id', 'contextid');
    }

    // Metode untuk menghasilkan gabungan dari semua tabel
    public function getAllJoinedData()
    {
        return $this->with(['roleAssignments', 'roles', 'contexts'])->get();
    }

    // public function classrooms()
    // {
    //     return $this->belongsToMany(Classroom::class, 'user_classroom', 'user_id', 'classroom_id');
    // }

    // public function users()
    // {
    //     return $this->belongsToMany(User::class, 'users_class', 'class_id', 'user_id');
    // }

    public function classrooms() {
        return $this->belongsToMany(Classroom::class, 'user_classroom', 'user_id', 'classroom_id');
    }

    public function attendances() {
        return $this->hasMany(Attendance::class, 'user_id');
    }

    public function ownClassrooms() {
        return $this->hasMany(Classroom::class, 'user_id');
    }

    public function AttendanceInformation() {
        return $this->hasOne(AttendanceInformation::class, 'user_id');
    }
}

class RoleAssignment extends Model
{
    protected $connection = 'moodle';
    protected $table = 'mdl_role_assignments';
    protected $primaryKey = 'id';

    protected $fillable = [
        'roleid', 'contextid', 'userid', 'timemodified', 'modifierid', 'component', 'itemid', 'sortorder'
    ];

    // Relasi ke tabel role
    public function role()
    {
        return $this->belongsTo(Role::class, 'roleid', 'id');
    }

    // Relasi ke tabel context
    public function context()
    {
        return $this->belongsTo(Context::class, 'contextid', 'id');
    }

    // Relasi ke tabel user
    public function user()
    {
        return $this->belongsTo(MoodleUser::class, 'userid', 'id');
    }
}

class Role extends Model
{
    protected $connection = 'moodle';
    protected $table = 'mdl_role';
    protected $primaryKey = 'id';

    protected $fillable = [
        'shortname', 'sortorder'
    ];
}

class Context extends Model
{
    protected $connection = 'moodle';
    protected $table = 'mdl_context';
    protected $primaryKey = 'id';

    protected $fillable = [
        'contextlevel', 'instanceid', 'path'
    ];
}
