@extends('pages.layouts.siswa')

@section('title', 'Data Pembelajaran')
@section('description', 'Berikut adalah semua data pembelajaran yang telah tercatat.')

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
                            <th>Tanggal</th>
                            <th>Judul</th>
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
    @include('pages.siswa.pembelajaran._show')
</section>
@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        var route = "{{ route('siswa.pembelajaran.index') }}";
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