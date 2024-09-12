<x-app-layout>
    <x-slot:title>Daftar presensi #{{ $classroom->code }} - {{ $classroom->name }}</x-slot:title>
    <div class="page-wrapper">
        <x-page-header title="Daftar pertemuan #{{ $classroom->code }} - {{ $classroom->name }}" />
        <x-page-body>
            <div class="row">
                @if (session('success'))
                    <div class="col-12">
                        <div class="alert alert-success alert-dismissible bg-white" role="alert">
                            <div class="d-flex">
                                <div>
                                    <i class="ti ti-check fs-2"></i>
                                </div>
                                <div>
                                    {{ session('success') }}
                                </div>
                            </div>
                            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                    </div>
                @endif
                @if (session('error'))
                    <div class="col-12 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- @for ($i = 1; $i <= 16; $i++)
                <div class="card accordion mb-3" id="accordion-pertemuan-{{ $i }}">
                    <div class="card-body p-0 shadow">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading-{{ $i }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse-{{ $i }}" aria-expanded="false">
                                    Pertemuan #{{ $i }}
                                </button>
                            </h2>
                            <div id="collapse-{{ $i }}" class="accordion-collapse collapse" data-bs-parent="#accordion-pertemuan-{{ $i }}"
                                style="">
                                <div class="accordion-body pt-0">
                                    Untuk melakukan presensi anda bisa mengakses tautan berikut ini <a href="{{ route('attendance') }}">tautan presensi</a>. <strong>Jika anda ingin melakukan absensi anda dapat mengakses tautan berikut ini</strong> <a href="{{ route('absent') }}">tautan absensi</a>.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endfor --}}
                @forelse ($classroom->meetings as $meeting)
                    <div class="col-12">
                        <div class="card accordion mb-3" id="accordion-pertemuan-{{ $loop->iteration }}">
                            <div class="card-body p-0 shadow">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading-{{ $loop->iteration }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-{{ $loop->iteration }}" aria-expanded="false">
                                            Pertemuan #{{ $loop->iteration }}
                                        </button>
                                    </h2>
                                    <div id="collapse-{{ $loop->iteration }}" class="accordion-collapse collapse"
                                        data-bs-parent="#accordion-pertemuan-{{ $loop->iteration }}" style="">
                                        <div class="accordion-body pt-0">
                                            <p>Tanggal & Waktu:
                                                {{ \Carbon\Carbon::parse($meeting->date)->locale('id')->translatedFormat('l, d F Y') }},
                                                {{ $meeting->start_time }} - {{ $meeting->end_time }}</p>
                                            <p>Untuk melakukan presensi anda bisa mengakses tautan berikut ini <a
                                                    href="{{ route('user.attendance.recognition', $meeting->id) }}">tautan
                                                    presensi</a>. <strong>Jika anda ingin
                                                    melakukan absensi, anda dapat mengakses tautan berikut ini</strong> <a
                                                    href="{{ route('user.absent.view', $meeting->id) }}">tautan absensi</a>.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <h3>Belum ada kelas</h3>
                @endforelse
            </div>
        </x-page-body>
    </div>
</x-app-layout>
