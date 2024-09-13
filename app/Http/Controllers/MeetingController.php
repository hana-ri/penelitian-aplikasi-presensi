<?php

namespace App\Http\Controllers;

use App\Models\Appendix;
use App\Models\Attendance;
use Illuminate\Http\Request;
use \App\Models\Classroom;
use App\Models\Meeting;
use App\Models\MoodleUser;
use App\Traits\SteganoDecode;
use App\Traits\SteganoEncode;

class MeetingController extends Controller
{
    use SteganoEncode, SteganoDecode;

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

            // // Ambil data kehadiran berdasarkan meeting_id
            // $attendances = $meeting->attendances()->get()->keyBy('user_id'); // Pastikan attendances memiliki user_id

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

                    if ($attendance) {
                        // Ambil data appendices jika ada
                        $appendices = $attendance->appendices;
                        if ($attendance->status == 'Permintaan pengajuan') {
                            return $attendance->status . ' - ' . $appendices->pluck('statement')->join(', ');
                        }
                        return $attendance->status;
                    }

                    return $attendance ? $attendance->status : 'Belum tersedia';
                })
                ->addColumn('lampiran', function (MoodleUser $user) use ($meeting) {
                    $attendance = $user->attendances()
                    ->where('meeting_id', $meeting->id)
                    ->where('user_id', $user->id)
                    ->first();

                    if ($attendance) {
                        // Ambil data appendices jika ada
                        $appendices = $attendance->appendices;
                        if($appendices->isEmpty()) {
                            if ($attendance->status == 'Absen') {
                                return '-';
                            }
                            return '<a href="'. route('admin.attandace.attachment', ['meeting_id' => $meeting->id, 'user_id' => $user->id]) .'">Lampiran Kehadiran</a>';
                            return 'Lampiran Kehadiran';
                        }
                        return '<a href="'. route('admin.absent.attachment', $appendices->first()->id) .'">Lampiran</a>';
                    }

                    return $attendance ? $attendance->status : '-';
                })
                ->addColumn('action', function (MoodleUser $user) use ($meeting) {
                    return view('admin.action', [
                        'user' => $user,
                        'meeting' => $meeting,
                    ]);
                })
                ->rawColumns(['lampiran', 'action'])
                ->make(true);
        }
        $noPertemuan = $request->query('pertemuan');

        return view('admin.show', compact('meeting', 'noPertemuan'));
    }

    public function updateAttendance(Request $request)
    {
        $meeting_id = $request->query('meeting_id');
        $user_id = $request->query('user_id');
        $action = $request->query('action');

        $attendance = Attendance::where('meeting_id', $meeting_id)
                        ->where('user_id', $user_id)
                        ->first();

        if ($action == 'Hadir') {
            $attendance->update([
                'status' => 'Hadir',
            ]);
        }

        if ($action == 'Absen') {
            Attendance::create([
                'meeting_id' => $meeting_id,
                'user_id' => $user_id,
                'date_time' => now(),
                'status' => 'Absen',
                'count' => 5
            ]);
        }

        if ($action == 'Sakit') {
            $attendance->update([
                'status' => 'Sakit',
            ]);
        }

        if ($action == 'Izin') {
            $attendance->update([
                'status' => 'Izin',
            ]);
        }

        return redirect()->back();
    }

    public function absentAttachment(Appendix $appendix) {
        return view('admin.absent', [
            'appendix' => $appendix,
        ]);
    }

    public function attandanceAttachment(Appendix $appendix, Request $request) {
        $meeting_id = $request->query('meeting_id');
        $user_id = $request->query('user_id');
        $action = $request->query('action');

        $user = MoodleUser::find($user_id)->AttendanceInformation;
        // $textToHide = '<p>Nama: '. $validatedData['name'] .'</p> <p>NIM: '. $validatedData['nim'] .' </p> <p>Fakultas: '. $validatedData['faculty'] .'</p> <p>Program studi: '. $validatedData['majoring'] .'</p>';
        // dd($user->AttendanceInformation->registered_face);


        $attendance = \App\Models\Attendance::where('meeting_id', $meeting_id)
                        ->where('user_id', $user_id)
                        ->first();

        // $user = \App\Models\MoodleUser::find($user_id);
        // dd($user->AttendanceInformation);

        // dd($moodleUser->AttendanceInformation);
        $lsbMessage = $this->extractMessageFromImage($user->registered_face);
        // dd($lsbMessage);

        return view('admin.attendance_attachment', [
            'meeting_id' => $meeting_id,
            'user_id' => $user_id,
            'user' => $user,
            'lsb_message' => $lsbMessage,
        ]);
    }
}
