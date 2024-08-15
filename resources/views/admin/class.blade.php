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
                    <a href="{{ route('admin.class.create') }}" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target=""
                        aria-label="Create New Post">
                        <i class="ti ti-plus fs-3"></i>
                    </a>
                </div>
            </div>
        </x-page-header>
        <x-page-body>
            <div class="row">
                @for ($i = 1; $i <= 3; $i++)
                    <div class="col-12 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Mata kuliah #{{ $i }}</h3>
                                <p class="text-secondary">Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                    Aperiam
                                    deleniti fugit incidunt, iste, itaque minima
                                    neque pariatur perferendis sed suscipit velit vitae voluptatem.</p>
                            </div>
                            <!-- Card footer -->
                            <div class="card-footer">
                                <a href="{{ route('admin.class.edit') }}" class="btn btn-yellow">Ubah</a>
                                <a href="{{ route('admin.class.list') }}" class="btn btn-primary">Lihat pertemuan</a>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </x-page-body>
    </div>
</x-app-layout>
