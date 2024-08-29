<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassroomController extends Controller
{
    public function index()
    {
        return view('admin.class', [
            'classrooms' => Classroom::all(),
        ]);
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|unique:classrooms,code',
            'name' => 'required|max:255',
            'description' => 'required',
            'start_date' => 'required',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time'
        ], [
            'required' => ':attribute harus diisi.',
            'unique' => ':attribute sudah terdaftar, silakan gunakan kode lain.',
            'max' => ':attribute tidak boleh lebih dari :max karakter.',
            'end_time.date_format' => 'Format Waktu Berakhir harus HH:MM.',
            'end_time.after' => 'Waktu Berakhir harus setelah Waktu Mulai.',
        ], [
            'code' => 'kode',
            'name' => 'nama',
            'description' => 'deskripsi',
            'start_date' => 'waktu mulai',
            'start_time' => 'waktu mulai',
            'end_time' => 'waktu berakhir',
        ]);

        try {
            DB::beginTransaction();

            $classroom = Classroom::create($validatedData);

            for ($i = 0; $i < 16; $i++) {
                $meetingDate = \Carbon\Carbon::parse($classroom->start_date)->addWeeks($i);

                \App\Models\Meeting::create([
                    'classroom_id' => $classroom->id,
                    'date' => $meetingDate,
                    'start_time' => $validatedData['start_time'],
                    'end_time' => $validatedData['end_time'],
                    'attachment' => '',
                ]);
            }

            DB::commit();

            return redirect()->route('admin.class.index')->with('success', 'Kelas telah berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan. Silakan hubungi administrator.' . ' ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(Classroom $classroom)
    {
        return view('admin.edit', [
            'classroom' => $classroom
        ]);
    }

    public function update(Request $request, Classroom $classroom)
    {
        $validatedData = $request->validate([
            'code' => 'required|unique:classrooms,code,' . $classroom->id,
            'name' => 'required|max:255',
            'description' => 'required',
        ], [
            'required' => ':attribute harus diisi.',
            'unique' => ':attribute sudah terdaftar, silakan gunakan kode lain.',
            'max' => ':attribute tidak boleh lebih dari :max karakter.',
        ], [
            'code' => 'kode',
            'name' => 'nama',
            'description' => 'deskripsi',
        ]);

        try {
            DB::beginTransaction();

            $classroom->update($validatedData);

            DB::commit();
            return redirect()->route('admin.class.index')->with('success', 'Kelas telah berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan. Silakan hubungi administrator.' . ' ' . $e->getMessage())
                ->withInput();
        }
    }

    public function enrollment(Classroom $classroom)
    {


        try {
            DB::beginTransaction();

            $user = auth()->user();
            $classroom->users()->sync($user);

            DB::commit();
            return redirect()->route('attendance.class')->with('success', 'Berhasil melakukan pendaftaran kelas.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat pendaftaran kelas. Silakan hubungi administrator.' . ' ' . $e->getMessage())
                ->withInput();
        }
    }

    public function delete(Classroom $classroom)
    {
        try {
            $classroom->delete();

            return redirect()->route('admin.class.index')->with('success', 'Kelas telah berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan. Silakan hubungi administrator.');
        }
    }
}
