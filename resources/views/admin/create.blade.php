<x-app-layout>
    <x-slot:title>Buat kelas</x-slot:title>
    <div class="page-wrapper">
        <x-page-header title="Buat kelas" />
        <x-page-body>
            @if (session('success'))
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-12">
                <form class="card" action="{{ route('admin.class.store') }}" method="POST">
                    @csrf
                    <div class="card-header">
                        <h3 class="card-title">Buat kelas</h3>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Kode</label>
                            <div class="col">
                                <input type="text" name="code" class="form-control" placeholder="CM101"
                                    value="{{ old('code') }}">
                                <small class="form-hint">Kode harus unique (belum pernah digunakan).</small>
                            </div>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Nama</label>
                            <div class="col">
                                <input type="text" name="name" class="form-control" placeholder="Kalkulus"
                                    value="{{ old('name') }}">
                                <small class="form-hint">Nama mata kuliah atau kelas</small>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Deskripsi</label>
                            <div class="col">
                                <textarea class="form-control" name="description" name="example-textarea-input" rows="6"
                                    placeholder="Deskripsi..">{{ old('description') }}</textarea>
                                <small class="form-hint">Deskripsi dari kelas atau mata kuliah</small>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Tanggal mulai pertemuan pertama</label>
                            <div class="col">
                                <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <i class="ti ti-calendar"></i>
                                    </span>
                                    <input class="form-control" placeholder="Pilih tanggal"
                                        id="datepicker-icon-prepend" name="start_date" value="{{ old('start_date') }}">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Waktu mulai</label>
                            <div class="col">
                                <input type="time" name="start_time" class="form-control"
                                    value="{{ old('start_time') }}" placeholder="10:00 AM">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Waktu berakhir</label>
                            <div class="col">
                                <input type="time" name="end_time" class="form-control" value="{{ old('end_time') }}"
                                    placeholder="11:00 AM">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
    </div>
    </x-page-body>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/vendor/tabler/libs/litepicker/dist/litepicker.js?1692870487') }}" defer></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                window.Litepicker && (new Litepicker({
                    element: document.getElementById('datepicker-icon-prepend'),
                    buttonText: {
                        previousMonth: `<i class="ti ti-chevron-left"></i>`,
                        nextMonth: `<i class="ti ti-chevron-right"></i>`,
                    },
                }));
            });
        </script>
    @endpush
</x-app-layout>
