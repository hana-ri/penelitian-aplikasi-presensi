<x-app-layout>
    <x-slot:title>Face register</x-slot:title>
    <div class="page-wrapper">
        <x-page-header title="Ajukan absen" />
        <x-page-body>
            <form action="{{ route('user.absent.process', $meeting->id) }}" method="post" class="card" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="card-body">
                    <div class="mb-3 row">
                        <label class="col-3 col-form-label required">Keterangan</label>
                        <div class="col">
                            <input type="text" class="form-control" aria-describedby="emailHelp"
                                placeholder="Sakit, Keperluan pribadi, dan sejenisnya." name="statement">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-3 col-form-label required">Deskripsi</label>
                        <div class="col">
                            <textarea class="form-control" name="description" rows="5">Big belly rude boy, million dollar hustler. Unemployed.</textarea>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-3 col-form-label required">Lampiran</label>
                        <div class="col">
                            <input type="file" name="attachment" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <div class="d-flex">
                        <a href="#" class="btn btn-link">Batal</a>
                        <button type="submit" class="btn btn-primary ms-auto">Simpan</button>
                    </div>
                </div>
            </form>
        </x-page-body>
    </div>
    @push('styles')
    @endpush
    @push('scripts')
    @endpush
</x-app-layout>
