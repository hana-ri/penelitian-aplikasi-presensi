<?php

namespace App\Http\Controllers;

use App\Models\Appendix;
use App\Models\AttendanceInformation;
use App\Models\Classroom;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserClassroomController extends Controller
{

    public function indexClassroom() {
        $userClassrooms = auth()->user()->classrooms;

        $existingRegistration = AttendanceInformation::where('user_id', auth()->user()->id)->first();

        if (!$existingRegistration) {
            return redirect()->route('user.create.face.register')->with('error', 'Daftarkan wajah anda terlebih dahulu.');
        }

        return view('attendance.class', [
            'classrooms' => $userClassrooms,
        ]);
    }

    public function indexMeeting(Classroom $classroom) {
        return view('attendance.list', [
            'classroom' => $classroom,
        ]);
    }

    public function enrollment(Classroom $classroom)
    {
        try {
            DB::beginTransaction();

            $user = auth()->user();

            // Cek apakah user sudah terdaftar di kelas
            if ($classroom->users->contains($user)) {
                // Jika user sudah ada, gunakan sync
                $classroom->users()->sync($user);
            } else {
                // Jika user belum ada, gunakan attach
                $classroom->users()->attach($user);
            }

            DB::commit();
            return redirect()->route('attendance.class')->with('success', 'Berhasil melakukan pendaftaran kelas.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat pendaftaran kelas. Silakan hubungi administrator.' . ' ' . $e->getMessage())
                ->withInput();
        }
    }

    public function absentView(Meeting $meeting) {
        $attendance = $meeting->attendances()->where('user_id', auth()->user()->id);
        // dd($attendance->first()->status);
        if ($attendance->exists() && $attendance->first()->count >= 5) {
            return redirect()->back()->with('success', 'Status kamu ' . $attendance->first()->status . '.');
        }

        return view('attendance.absent',[
            'meeting' => $meeting,
        ]);
    }

    public function absentProcess(Meeting $meeting, Request $request) {
        $user = auth()->user();
        $validatedData = $request->validate([
            'statement' => 'required',
            'description' => 'required|string|max:500',
            'attachment' => 'nullable|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = \Illuminate\Support\Str::uuid() . '.' . $file->getClientOriginalExtension(); // Buat nama file unik
            $filePath = $file->storeAs('attachments', $fileName, 'public'); // Simpan dengan nama file unik
            $validatedData['attachment'] = $filePath; // Tambahkan path file ke data yang akan disimpan
        }

        $user = auth()->user();
            $attendance = $meeting->attendances()
                ->where('user_id', $user->id);

        if (!$attendance->exists()) {
            $attendance = $meeting->attendances()->create([
                'user_id' => $user->id,
                'date_time' => now(),
                'status' => 'Permintaan pengajuan',
                'count' => 5
            ]);
        }

        $attendance->appendices()->create($validatedData);
        return redirect()->route('user.class.index')->with('success', 'Pangajuan izin presensi sedang dilakukan silakan konfirmasi ke pengampu kelas');
    }
}
