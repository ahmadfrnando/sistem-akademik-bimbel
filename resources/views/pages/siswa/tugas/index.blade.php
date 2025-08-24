@extends('pages.layouts.siswa')

@section('title', 'Data Tugas')
@section('description', 'Berikut adalah semua data tugas yang telah tercatat.')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                Semua Tugas
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table data-table" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Tugas</th>
                            <th>Kategori Tugas</th>
                            <th>Guru</th>
                            <th>Jam</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        var route = "{{ route('siswa.tugas.index') }}";
        var selector = ".data-table";
        var columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                className: 'w-8 text-center text-sm',
                orderable: false,
                searchable: false
            },
            {
                data: 'tanggal',
                name: 'tanggal',
                render: function(data, type, row) {
                    return data ? moment(data).locale('id').format('ll') : '-';
                }
            },
            {
                data: 'judul',
                name: 'judul',
                orderable: true,
                searchable: true
            },
            {
                data: 'kategori',
                name: 'kategori',
                orderable: true,
                searchable: true
            },
            {
                data: 'guru',
                name: 'guru',
                orderable: true,
                searchable: true
            },
            {
                data: 'jam',
                name: 'jam',
                orderable: false,
                searchable: false
            },
            {
                data: 'status',
                name: 'status',
                orderable: true,
                searchable: true
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ];
        var table = initializeDataTable(selector, route, columns);
    });
</script>
@endpush
@endsection