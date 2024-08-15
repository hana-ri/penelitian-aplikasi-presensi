<x-app-layout>
    <x-slot:title>Daftar presensi</x-slot:title>
    <div class="page-wrapper">
        <x-page-header title="Daftar presensi" />
        <x-page-body>
            @for ($i = 1; $i <= 16; $i++)
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
            @endfor
        </x-page-body>
    </div>
</x-app-layout>
