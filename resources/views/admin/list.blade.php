<x-app-layout>
    <x-slot:title>Daftar pertemuan</x-slot:title>
    <div class="page-wrapper">
        <x-page-header title="Daftar pertemuan" />
        <x-page-body>
            @for ($i = 1; $i <= 3; $i++)
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Pertemuan #{{ $i }}</h3>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('admin.class.show') }}" class="btn btn-primary">Hasil presensi</a>
                        </div>
                    </div>
                </div>
            @endfor
        </x-page-body>
    </div>
</x-app-layout>
