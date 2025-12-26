@extends('pages.layouts.admin')

@section('title', 'Data Pembelajaran')
@section('description', 'Berikut adalah semua data pembelajaran yang telah dikirim guru.')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                Semua Pembelajaran
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table data-table" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Guru</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>file</th>
                            <th>Status</th>
                            <th>keterangan</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    @include('pages.admin.pembelajaran._show')
</section>
@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        var route = "{{ route('admin.pembelajaran.index') }}";
        var selector = ".data-table";
        var columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                className: 'w-8 text-center text-sm',
                orderable: false,
                searchable: false
            },
            {
                data: 'judul',
                name: 'judul',
                orderable: true,
                searchable: true
            },
            {
                data: 'guru_id',
                name: 'guru_id',
            },
            {
                data: 'tanggal',
                name: 'tanggal',
                render: function(data, type, row) {
                    return moment(data).locale('id').format('ll') ?? '-';
                }
            },
            {
                data: 'jam',
                name: 'jam',
            },
            {
                data: 'file',
                name: 'file',
            },
            {
                data: 'status',
                name: 'status',
            },
            {
                data: 'keterangan',
                name: 'keterangan',
                className: 'w-20',
            },
        ];
        var table = initializeDataTable(selector, route, columns);
    });

    function showFunc(fileParams) {
        $('#modalShow').modal('show');
        var file = fileParams;
        $('#modalShowFile').find('.modal-title').html('Lihat Lampiran');
        let url = "{{ asset('storage') }}/" + file;
        $('#showFile').attr('data', url);
        $('#modalShowFile').modal('show');
    }
</script>
@endpush
@endsection