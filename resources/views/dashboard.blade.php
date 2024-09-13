<x-app-layout>
    <x-slot:title>Dashboard</x-slot:title>
    <div class="page-wrapper">
        <x-page-header title="Dashboard" />
        <x-page-body>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive p-1">
                        @if (auth()->user()->roles->contains('shortname', 'manager'))
                            <table class="table table-striped table-hover users-table" id="dataTables">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kelas</th>
                                        <th>Pertemuan</th>
                                        <th>Nama</th>
                                        <th>Status</th>
                                        <th>Tanggal & Waktu</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        @else
                        <table class="table table-striped table-hover users-table" id="dataTables">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kelas</th>
                                    <th>Pertemuan</th>
                                    <th>Status</th>
                                    <th>Tanggal & Waktu</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                            {{-- <table class="table table-striped table-hover users-table">
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
                            </table> --}}
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
    <script src="{{ asset('assets/vendor/DataTables/datatables.js') }}" defer></script>
    <script>
        $(document).ready(function() {
            $('#dataTables').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('dashboard') }}',
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'id',
                    searchable: false,
                }, {
                    data: 'classname',
                    name: 'classname'
                },
                {
                    data: 'meeting',
                    name: 'meeting'
                },
                @if (auth()->user()->roles->contains('shortname', 'manager'))
                {
                    data: 'fullname',
                    name: 'fullname'
                },
                @endif
                {
                    data: 'attendance_status',
                    name: 'attendance_status'
                },
                {
                    data: 'date_time',
                    name: 'date_time'
                }],
                order: [[5, 'asc']],
            });
        });
    </script>
@endpush
</x-app-layout>
