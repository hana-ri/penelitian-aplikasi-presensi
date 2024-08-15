<x-app-layout>
    <x-slot:title>Buat kelas</x-slot:title>
    <div class="page-wrapper">
        <x-page-header title="Buat kelas" />
        <x-page-body>
            <div class="row">
                <div class="col-12">
                    <form class="card">
                        <div class="card-header">
                            <h3 class="card-title">Buat kelas</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Kode</label>
                                <div class="col">
                                    <input type="email" class="form-control" aria-describedby="emailHelp"
                                        placeholder="CM101">
                                    <small class="form-hint">Kode harus unique (belum pernah digunakan).</small>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Nama</label>
                                <div class="col">
                                    <input type="email" class="form-control" aria-describedby="emailHelp"
                                        placeholder="Kalkulus">
                                    <small class="form-hint">Nama mata kuliah atau kelas</small>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Deskripsi</label>
                                <div class="col">
                                    <textarea class="form-control" name="example-textarea-input" rows="6" placeholder="Deskripsi.."></textarea>
                                    <small class="form-hint">Deskripsi dari kelas atau mata kuliah</small>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Waktu mulai</label>
                                <div class="col">
                                    <input type="email" class="form-control" aria-describedby="emailHelp"
                                        placeholder="10:00">
                                    <small class="form-hint">Range 00:00 hingga 23:59</small>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Waktu berakhir</label>
                                <div class="col">
                                    <input type="email" class="form-control" aria-describedby="emailHelp"
                                        placeholder="10:00">
                                    <small class="form-hint">Range 00:00 hingga 23:59</small>
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
</x-app-layout>
