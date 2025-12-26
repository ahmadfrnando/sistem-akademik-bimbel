@extends('pages.layouts.admin')

@section('title', 'Data Tugas')
@section('description', 'Berikut adalah semua data tugas yang telah tercatat.')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">
                Semua Tugas
            </h5>
            <a onClick="add()" href="javascript:void(0)" class="btn btn-add btn-warning block">
                <i class="bi bi-plus me-1 fs-5"></i>Tambah Tugas
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table data-table" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Tugas</th>
                            <th>Jam</th>
                            <th>Total Jawaban</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    @include('pages.admin.tugas._show_submissions')
</section>
@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        var route = "{{ route('admin.tugas.index') }}";
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
                orderable: true,
                searchable: true,
                render: function(data, type, row) {
                    return moment(data).locale('id').format('ll') ?? '-';
                }
            },
            {
                data: 'judul',
                name: 'judul',
                orderable: true,
                searchable: true
            },
            {
                data: 'jam',
                name: 'jam'
            },
            {
                data: 'total_jawaban',
                name: 'total_jawaban',
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
        ];
        var table = initializeDataTable(selector, route, columns);
    });

    function showSubmissionFunc(id) {
        $('#modalShow').modal('show');
        var oTable = $('.data-table-show').dataTable();
        oTable.fnDraw(false);
        var route = "{{ route('admin.tugas.submissions', ':id') }}";
        route = route.replace(':id', id);
        var selector = ".data-table-show";
        var columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                className: 'w-8 text-center text-sm',
                orderable: false,
                searchable: false
            },
            {
                data: 'siswa',
                name: 'siswa',
                orderable: true,
                searchable: true
            },
            {
                data: 'nilai',
                name: 'nilai',
                orderable: true,
                searchable: true
            },
            {
                data: 'created-at',
                name: 'created-at',
                render: function(data, type, row) {
                    return moment(data).locale('id').format('ll') ?? '-';
                }
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ];
        var table = initializeDataTable(selector, route, columns);
    }
</script>
@endpush
@endsection