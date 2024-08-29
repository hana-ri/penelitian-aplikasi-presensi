<x-app-layout>
    <x-slot:title>Daftar pertemuan</x-slot:title>
    <div class="page-wrapper">
        <x-page-header title="Daftar pertemuan" />
        <x-page-body>
            @foreach ($classroom->meetings as $meeting)
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Pertemuan #{{ $loop->iteration }}</h3>

                        </div>
                        <div class="card-body">
                            <p>Tanggal: {{ $meeting->date }}</p>
                            <p>Jam: {{ $meeting->start_time }} - {{ $meeting->end_time }}</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('admin.class.show') }}" class="btn btn-primary">Lihat</a>
                            {{-- <a href="{{ route('admin.class.show') }}" class="btn btn-warning">Tutup pertemuan</a> --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </x-page-body>
    </div>
</x-app-layout>
