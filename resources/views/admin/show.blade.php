<x-app-layout>
    <x-slot:title>Daftar kehadiran</x-slot:title>
    <div class="page-wrapper">
        <x-page-header title="Daftar kehadiran" />
        <x-page-body>
            <div class="col-12">
                <div class="card mb-3">
                    <div class="accordion" id="data-filter">
                        <div class="accordion-item border-0">
                            <h2 class="accordion-header" id="heading-1">
                                <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse-1" aria-expanded="true"><svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-filter-filled" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path
                                            d="M20 3h-16a1 1 0 0 0 -1 1v2.227l.008 .223a3 3 0 0 0 .772 1.795l4.22 4.641v8.114a1 1 0 0 0 1.316 .949l6 -2l.108 -.043a1 1 0 0 0 .576 -.906v-6.586l4.121 -4.12a3 3 0 0 0 .879 -2.123v-2.171a1 1 0 0 0 -1 -1z"
                                            stroke-width="0" fill="currentColor"></path>
                                    </svg> Filter </button>
                            </h2>
                            <div id="collapse-1" class="accordion-collapse collapse show" data-bs-parent="#data-filter"
                                style="">
                                <div class="accordion-body pt-0">
                                    <form id="form-filter">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Nama</label>
                                                    <input type="text" name="date_range" id="date-range"
                                                        placeholder="Cari nama mahasiswa" class="form-control"><span
                                                        style="position: absolute; pointer-events: none;"
                                                        class="easepick-wrapper"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Status</label>
                                                            <select name="filter_inventory_category"
                                                                id="filter-inventory-category" class="form-select">
                                                                <option value="" selected="" disabled="">
                                                                    Pilih status</option>
                                                                <option value="">Sudah Presensi</option>
                                                                <option value="">Belum Presensi</option>
                                                                <option value="">Izin</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="my-2 text-end">
                                        <button type="button" class="btn btn-warning py-1 px-5" id="reset-filter">Reset
                                            Filter</button>
                                        <button type="button" class="btn btn-primary py-1 px-5"
                                            id="search-now">Cari</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive p-1">
                                @if (auth()->user()->roles->contains('shortname', 'manager'))
                                    <table class="table table-striped table-hover users-table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Hari, Tanggal</th>
                                                <th>Waktu masuk</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Sarah</td>
                                                <td>Selasa, 14 Oktober 2024</td>
                                                <td>14:37</td>
                                                <td>Sudah presensi</td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Siti Asia</td>
                                                <td>Selasa, 14 Oktober 2024</td>
                                                <td>-</td>
                                                <td>Izin</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-page-body>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/vendor/DataTables/datatables.css') }}">
    @endpush

    @push('scripts')
        <script>
            $(function() {
                let table = $('.users-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: "#",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'id',
                            searchable: false,
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'hari_tanggal',
                            name: 'hari_tanggal'
                        },
                        {
                            data: 'waktu_masuk',
                            name: 'waktu_masuk'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });
            });
        </script>
    @endpush
</x-app-layout>
