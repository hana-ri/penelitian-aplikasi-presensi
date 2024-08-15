<x-app-layout>
    <x-slot:title>Dashboard</x-slot:title>
    <div class="page-wrapper">
        <x-page-header title="Dashboard" />
        <x-page-body>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive p-1">
                        @if (auth()->user()->roles->contains('shortname', 'manager'))
                            <table class="table table-striped table-hover users-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Kelas</th>
                                        <th>Hari, Tanggal</th>
                                        <th>Waktu masuk</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Sarah</td>
                                        <td>Keamanan dan Jaringan</td>
                                        <td>Selasa, 14 Oktober 2024</td>
                                        <td>14:37</td>
                                        <td>Sudah presensi</td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>Siti Asia</td>
                                        <td>Kalkulus</td>
                                        <td>Selasa, 14 Oktober 2024</td>
                                        <td>-</td>
                                        <td>Izin</td>
                                    </tr>
                                </tbody>
                            </table>
                        @else
                            <table class="table table-striped table-hover users-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kelas</th>
                                        <th>Hari, Tanggal</th>
                                        <th>Waktu masuk</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Keamanan dan Jaringan</td>
                                        <td>Selasa, 14 Oktober 2024</td>
                                        <td>14:37</td>
                                        <td>Sudah presensi</td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif
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
                let userId = "xxx";
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
                            data: 'username',
                            name: 'username'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'roles',
                            name: 'roles'
                        },
                        {
                            data: 'email_verified_at',
                            name: 'email_verified_at',
                            searchable: false,
                            render: function(data, type, full, meta) {
                                if (data) {
                                    return '<span class="badge bg-green text-green-fg">Verified</span>';
                                } else {
                                    return '<span class="badge bg-red text-red-fg">Not verified</span>';
                                }
                            }
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'updated_at',
                            name: 'updated_at'
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
