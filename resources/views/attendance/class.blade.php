<x-app-layout>
    <x-slot:title>Daftar kelas</x-slot:title>
    <div class="page-wrapper">
        <x-page-header title="Daftar kelas" />
        <x-page-body>
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
            @foreach ($classrooms as $classroom)
                <div class="card mb-3">
                    <div class="card-body">
                        <h3 class="card-title">#{{ $classroom->code }} - Mata Kuliah {{ $classroom->name }}</h3>
                        <p class="text-secondary">Pengampu: {{ $classroom->ownUser->full_name }}</p>
                        <p class="text-secondary">Deskripsi: {{ $classroom->description }}</p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('user.class.attendance.index', $classroom->code) }}" class="btn btn-primary">Buka</a>
                    </div>
                </div>
            @endforeach
        </x-page-body>
    </div>
</x-app-layout>
