<x-app-layout>
    <x-slot:title>Perbarui data kelas</x-slot:title>
    <div class="page-wrapper">
        <x-page-header title="Perbarui data kelas #{{ $classroom->code }} - {{ $classroom->name }}" />
        <x-page-body>
            <div class="row">
                <div class="col-12">
                    <form class="card" action="{{ route('admin.class.update', $classroom->code) }}" method="POST">
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
                                        value="{{ old('code', $classroom->code ?? '') }}">
                                    <small class="form-hint">Kode harus unik.</small>
                                </div>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Nama</label>
                                <div class="col">
                                    <input type="text" name="name" class="form-control" placeholder="Kalkulus"
                                        value="{{ old('name', $classroom->name ?? '') }}">
                                    <small class="form-hint">Nama mata kuliah atau kelas</small>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Mode pendaftaran</label>
                                <div class="col">
                                    <select class="form-select" name="is_enrollment">
                                        <option value="1" @selected(old('is_enrollment', $classroom->is_enrollment))>Aktif</option>
                                        <option value="0" @selected(!old('is_enrollment', $classroom->is_enrollment))>Nonaktif</option>
                                    </select>
                                    <small class="form-hint">Nama mata kuliah atau kelas</small>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Deskripsi</label>
                                <div class="col">
                                    <textarea class="form-control" name="description" name="example-textarea-input" rows="6"
                                        placeholder="Deskripsi..">{{ old('description', $classroom->description ?? '') }}</textarea>
                                    <small class="form-hint">Deskripsi dari kelas atau mata kuliah</small>
                                </div>
                            </div>
                            {{-- <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Tanggal mulai pertemuan pertama</label>
                                <div class="col">
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-calendar"></i>
                                        </span>
                                        <input class="form-control" placeholder="Pilih tanggal"
                                            id="datepicker-icon-prepend" name="start_date">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Waktu mulai</label>
                                <div class="col">
                                    <input type="time" name="start_time" class="form-control"
                                    value="{{ old('start_time', $classroom->start_time ?? '') }}" placeholder="10:00">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Waktu berakhir</label>
                                <div class="col">
                                    <input type="time" name="end_time" class="form-control"
                                    value="{{ old('end_time', $classroom->end_time ?? '') }}" placeholder="10:00">
                                </div>
                            </div> --}}
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
