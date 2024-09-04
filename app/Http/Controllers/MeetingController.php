<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use \App\Models\Classroom;
use App\Models\Meeting;
use App\Models\MoodleUser;
use Yajra\DataTables\Facades\DataTables;

class MeetingController extends Controller
{
    public function indexClassroom(Classroom $classroom)
    {
        return view('admin.list', [
            'classroom' => $classroom,
        ]);
    }

    public function indexMeeting(Meeting $meeting, Request $request)
    {
        if ($request->ajax()) {
            // Ambil semua pengguna yang terdaftar pada kelas
            $users = $meeting->classroom->users;

            // Mendapatkan classroom dari meeting
            $classroom = $meeting->classroom;

            // Ambil data kehadiran berdasarkan meeting_id
            $attendances = $meeting->attendances()->get()->keyBy('user_id'); // Pastikan attendances memiliki user_id

            // Gabungkan data pengguna, kelas, meeting, dan kehadiran untuk dikirim ke datatables
            return datatables()->of($users)
                ->addIndexColumn()
                ->addColumn('fullname', function ($user) {
                    return $user->fullname;
                })
                ->addColumn('classroom_name', function () use ($classroom) {
                    return $classroom->name;
                })
                ->addColumn('attendance_status', function (MoodleUser $user) use ($meeting) {
                    $attendance = $user->attendances()->where('meeting_id', $meeting->id)->first();
                    return $attendance ? $attendance->status : 'Belum tersedia';
                })
                ->addColumn('action', function (MoodleUser $user) use ($meeting) {
                    return view('admin.action');
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $noPertemuan = $request->query('pertemuan');

        return view('admin.show', compact('meeting', 'noPertemuan'));
    }
}
