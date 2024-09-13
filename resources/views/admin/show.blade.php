<x-app-layout>
    <x-slot:title>Daftar kehadiran pertemuan #</x-slot:title>
    <div class="page-wrapper">
        <x-page-header title="Daftar kehadiran pertemuan #{{ $noPertemuan }}" />
        <x-page-body>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive p-1">
                                {{-- @if (auth()->user()->roles->contains('shortname', 'manager')) --}}
                                {{-- @endif --}}
                                <table class="table table-striped table-hover users-table" id="dataTables">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Status presensi</th>
                                            <th>Lampiran</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
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
        <script src="{{ asset('assets/vendor/DataTables/datatables.js') }}" defer></script>
        <script>
            $(document).ready(function() {
                $('#dataTables').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('admin.attendance.meeting.list', $meeting->id) }}',
                    columns: [{
                        data: 'DT_RowIndex',
                        name: 'id',
                        searchable: false,
                    }, {
                        data: 'fullname',
                        name: 'fullname'
                    },
                    {
                        data: 'attendance_status',
                        name: 'attendance_status'
                    },
                    {
                        data: 'lampiran',
                        name: 'lampiran'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
                });
            });
        </script>
    @endpush
</x-app-layout>
