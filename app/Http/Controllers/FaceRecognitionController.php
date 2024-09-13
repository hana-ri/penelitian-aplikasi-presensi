<?php

namespace App\Http\Controllers;

use App\Models\AttendanceInformation;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Traits\SteganoEncode;
use App\Traits\SteganoDecode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FaceRecognitionController extends Controller
{
    use SteganoEncode, SteganoDecode;

    public function indexFaceRegister()
    {
        $existingRegistration = AttendanceInformation::where('user_id', auth()->user()->id)->first();

        if ($existingRegistration) {
            return redirect()->route('user.class.index')->with('error', 'Wajah Anda sudah terdaftar. Anda tidak dapat mengubah data ini.');
        }

        return view('attendance.face_register');
    }

    public function indexAttendance(Meeting $meeting)
    {
        // dd($meeting->date, now()->toDateString(), ($meeting->date == now()->toDateString()), now()->toTimeString(), $meeting->start_time, (now()->toTimeString() >= $meeting->start_time), now()->toTimeString(), $meeting->end_time, (now()->toTimeString() <= $meeting->end_time));
        // if (!($meeting->date == now()->toDateString()) && now()->toTimeString() >= $meeting->start_time && now()->toTimeString() <= $meeting->end_time) {
        //     return redirect()->back()->with('success', 'Belum dibuka');
        // }

        if ($meeting->date == now()->toDateString() && now()->toTimeString() >= $meeting->start_time && now()->toTimeString() <= $meeting->end_time) {
            $attendance = $meeting->attendances()->where('user_id', auth()->user()->id);

            if ($attendance->exists() && $attendance->first()->count >= 5) {
                return redirect()->back()->with('success', 'Status kamu ' . $attendance->first()->status . '.');
            }

            return view('attendance.face_recognition', [
                'meeting' => $meeting
            ]);
        }

        return redirect()->back()->with('error', 'Pertemuan belum dibuka');
    }

    public function createFaceRegister(Request $request)
    {
        $existingRegistration = AttendanceInformation::where('user_id', auth()->user()->id)->first();

        if ($existingRegistration) {
            return redirect()->route('user.class.index')->with('error', 'Anda sudah terdaftar. Anda tidak dapat mengubah data ini.');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|max:20',
            'faculty' => 'required|string|max:255',
            'majoring' => 'required|string|max:255',
            'registered_face' => 'required|string|regex:/^data:image\/jpeg;base64,/',
        ], [
            'required' => ':attribute harus diisi.',
            'string' => ':attribute harus berupa teks.',
            'max' => ':attribute tidak boleh lebih dari :max karakter.',
            'regex' => ':attribute tidak valid. Pastikan formatnya benar.',
        ], [
            'name' => 'nama',
            'nim' => 'NIM',
            'faculty' => 'fakultas',
            'majoring' => 'jurusan',
            'registered_face' => 'gambar wajah',
        ]);


        $textToHide = '<p>Nama: '. $validatedData['name'] .'</p> <p>NIM: '. $validatedData['nim'] .' </p> <p>Fakultas: '. $validatedData['faculty'] .'</p> <p>Program studi: '. $validatedData['majoring'] .'</p>';

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['registered_face'] = str_replace('data:image/jpeg;base64,', '', $validatedData['registered_face']);

        $hiddenImage = $this->hideTextInImage($textToHide, $validatedData['registered_face']);
        $validatedData['registered_face'] = base64_decode($hiddenImage);

        try {
            DB::beginTransaction();

            AttendanceInformation::create($validatedData);

            DB::commit();
            return redirect()->route('user.class.index')->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan. Silakan hubungi administrator.' . ' ' . $e->getMessage())
                ->withInput();
        }
    }

    public function showFaceImage(Request $request)
    {
        // dd($request->missing('user_id'));
        if ($request->has('user_id') && $request->missing('meeting_id')) {
            $user_id = $request->query('user_id');

            $user = \App\Models\MoodleUser::find($user_id);

            $attendance = $user->AttendanceInformation;

            if (!$attendance || !$attendance->registered_face) {
                return response()->json(['error' => 'Image not found'], 404);
            }

            $imageData = $attendance->registered_face;
            // @dd($this->extractMessageFromImage($imageData));

            return response($imageData, 200)->header('Content-Type', 'image/jpeg');
        }

        if ($request->has('user_id') && $request->has('meeting_id')) {
            $user_id = $request->query('user_id');
            $meeting_id = $request->query('meeting_id');

            $attendance = \App\Models\Attendance::where('meeting_id', $meeting_id)
                        ->where('user_id', $user_id)
                        ->first();


            // dd($attendance->attendance_attachment);

            if (!$attendance || !$attendance->attendance_attachment) {
                return response()->json(['error' => 'Image not found'], 404);
            }

            $imageData = $attendance->attendance_attachment;

            return response($imageData, 200)->header('Content-Type', 'image/jpeg');
        }
    }

    // ===============================================================================================

    public function recognize(Meeting $meeting, Request $request)
    {
        // Ambil gambar dari request
        $attendance_image_encoded = $request->input('image');

        // Gambar yang sudah didecode
        $attendance_image_decoded = base64_decode($attendance_image_encoded);

        // Buat nama file unik
        $fileName = 'capture_' . time() . '.jpg';

        $registered_image = Auth::guard('moodle')->user()->AttendanceInformation()->first()->registered_face;

        $verifyResponse = $this->verify(base64_encode($registered_image), $attendance_image_encoded);

        // Jika responsenya match/true maka simpan ke attendance
        if ($verifyResponse['is_match']) {
            $user = auth()->user();
            $attendance = $meeting->attendances()
                ->where('user_id', $user->id);

            if (!$attendance->exists()) {
                $meeting->attendances()->create([
                    'user_id' => $user->id,
                    'date_time' => now(),
                    'status' => 'Sedang presensi',
                    'attendance_attachment' => $registered_image,
                    'count' => 1
                ]);
                $verifyResponse['status_presensi'] = 'Sedang presensi';
            } else {
                $attendanceData = $attendance->first();

                if ($attendanceData->status !== 'Hadir') {
                    if ($attendanceData->count < 4) {
                        $attendanceData->update([
                            'count' => $attendance->first()->count + 1,
                        ]);
                        $verifyResponse['status_presensi'] = 'Sedang presensi';
                    } else {
                        $attendanceData->update([
                            'status' => 'Hadir',
                            'count' => $attendance->first()->count + 1,
                        ]);
                        $verifyResponse['status_presensi'] = 'Hadir';
                    }
                }
            }
        }

        return response()->json($verifyResponse);
    }

    public function verify($registered_image, $attendance_image)
    {
        try {
            $response = Http::post('http://127.0.0.1:5000/verify', [
                'registered_image' => $registered_image,
                'attendance_image' => $attendance_image,
            ]);

            if ($response->successful()) {
                return $response->json();
            } else {
                return [
                    'error' => 'Request failed with status: ' . $response->status(),
                    'response_body' => $response->body(),
                ];
            }
        } catch (\Exception $e) {
            return ['error' => 'An error occurred: ' . $e->getMessage()];
        }
    }
}
