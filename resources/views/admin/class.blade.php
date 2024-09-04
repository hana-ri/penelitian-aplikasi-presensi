<x-app-layout>
    <x-slot:title>Daftar presensi</x-slot:title>
    <div class="page-wrapper">
        <x-page-header title="Kelola kelas">
            <div class="d-flex">
                <div class="btn-list">
                    <a href="{{ route('admin.class.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                        <i class="ti ti-plus fs-3"></i>
                        Buat kelas
                    </a>
                    <a href="{{ route('admin.class.create') }}" class="btn btn-primary d-sm-none btn-icon"
                        data-bs-toggle="modal" data-bs-target="" aria-label="Create New Post">
                        <i class="ti ti-plus fs-3"></i>
                    </a>
                </div>
            </div>
        </x-page-header>
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

                @foreach ($classrooms as $classroom)
                    <div class="col-12 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">#{{ $classroom->code }} - Mata Kuliah {{ $classroom->name }}</h3>
                                <p class="text-secondary">Tanggal Mulai: {{ \Carbon\Carbon::parse($classroom->date)->locale('id')->translatedFormat('l, d F Y') }}</p>
                                <p class="text-secondary">Deskripsi: {{ $classroom->description }}</p>
                                @if ($classroom->is_enrollment)
                                <p class="text-secondary"><a href="{{ route('user.class.enrollment', $classroom->code) }}"> {{ route('user.class.enrollment', $classroom->code) }}</a></p>
                                @endif
                            </div>
                            <div class="card-footer text-end">
                                <div class="d-flex">
                                    <label class="row">
                                        <span class="col">Mode pendaftaran: {!! $classroom->is_enrollment ? '<span class="badge bg-green text-green-fg">Aktif</span>' : '<span class="badge bg-orange text-orange-fg">Nonaktif</span>' !!}</span>
                                    </label>
                                    <div class="ms-auto">
                                        <a href="{{ route('admin.attendance.list', $classroom->code) }}"
                                            class="btn btn-primary me-3">Lihat pertemuan</a>
                                        <a href="{{ route('admin.class.edit', $classroom->code) }}"
                                            class="btn btn-yellow me-3">Ubah</a>
                                        <form id="delete-form-{{ $classroom->code }}"
                                            action="{{ route('admin.class.destroy', $classroom->code) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger"
                                                onclick="confirmDeletion('{{ $classroom->code }}')">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-page-body>
    </div>

    @push('scripts')
        <script>
            function confirmDeletion(code) {
                if (confirm('Apakah Anda yakin ingin menghapus kelas ini?')) {
                    document.getElementById('delete-form-' + code).submit();
                }
            }
        </script>
    @endpush
</x-app-layout>
