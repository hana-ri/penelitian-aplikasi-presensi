<x-app-layout>
    <x-slot:title>Perbarui data kelas</x-slot:title>
    <div class="page-wrapper">
        <x-page-header title="Perbarui data kelas">
            <div class="d-flex">
                <div class="btn-list">
                    <a href="#" class="btn btn-primary d-none d-sm-inline-block">
                        <i class="ti ti-plus fs-3"></i>
                        Buat kelas
                    </a>
                    <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target=""
                        aria-label="Create New Post">
                        <i class="ti ti-plus fs-3"></i>
                    </a>
                </div>
            </div>
        </x-page-header>
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
                                        placeholder="CM101" value="CM101">
                                    <small class="form-hint">Kode harus unique (belum pernah digunakan).</small>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Nama</label>
                                <div class="col">
                                    <input type="email" class="form-control" aria-describedby="emailHelp"
                                        placeholder="Kalkulus" value="Kalkulus">
                                    <small class="form-hint">Nama mata kuliah atau kelas</small>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Deskripsi</label>
                                <div class="col">
                                    <textarea class="form-control" name="example-textarea-input" rows="6" placeholder="Content..">Oh! Come and see the violence inherent in the system! Help, help, I'm being repressed! We shall say 'Ni' again to you, if you do not appease us. I'm not a witch. I'm not a witch. Camelot!</textarea>
                                    <small class="form-hint">Deskripsi dari kelas atau mata kuliah</small>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Waktu mulai</label>
                                <div class="col">
                                    <input type="email" class="form-control" aria-describedby="emailHelp"
                                        placeholder="10:00" value="10:00">
                                    <small class="form-hint">Range 00:00 hingga 23:59</small>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Waktu berakhir</label>
                                <div class="col">
                                    <input type="email" class="form-control" aria-describedby="emailHelp"
                                        placeholder="10:00" value="12:00">
                                    <small class="form-hint">Range 00:00 hingga 23:59</small>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-warning">Ubah</button>
                        </div>
                    </form>
                </div>
            </div>
        </x-page-body>
    </div>
</x-app-layout>
