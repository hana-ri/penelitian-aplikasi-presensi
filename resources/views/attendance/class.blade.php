<x-app-layout>
    <x-slot:title>Daftar kelas</x-slot:title>
    <div class="page-wrapper">
        <x-page-header title="Daftar kelas" />
        <x-page-body>
            @for ($i = 1; $i <= 3; $i++)
                <div class="card mb-3">
                    <div class="card-body">
                        <h3 class="card-title">Mata kuliah #{{ $i }}</h3>
                        <p class="text-secondary">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam
                            deleniti fugit incidunt, iste, itaque minima
                            neque pariatur perferendis sed suscipit velit vitae voluptatem.</p>
                    </div>
                    <!-- Card footer -->
                    <div class="card-footer">
                        <a href="{{ route('attendance.list') }}" class="btn btn-primary">Buka</a>
                    </div>
                </div>
            @endfor
        </x-page-body>
    </div>
</x-app-layout>
