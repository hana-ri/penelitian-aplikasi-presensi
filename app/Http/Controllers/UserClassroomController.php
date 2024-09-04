<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Support\Facades\DB;

class UserClassroomController extends Controller
{

    public function indexClassroom() {
        $userClassrooms = auth()->user()->classrooms;

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
}
