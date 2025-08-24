@extends('pages.layouts.guru')

@section('title', 'Data Siswa')
@section('description', 'Berikut adalah semua data siswa yang telah tercatat.')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                Data Siswa
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table data-table" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Tanggal Lahir</th>
                            <th>Alamat</th>
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
    $(function() {
        var route = "{{ route('guru.siswa.index') }}";
        var selector = ".data-table";
        var columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                className: 'w-8 text-center text-sm',
                orderable: false,
                searchable: false
            },
            {
                data: 'nama',
                name: 'nama',
                orderable: true,
                searchable: true
            },
            {
                data: 'tgl_lahir',
                name: 'tgl_lahir',
                orderable: true,
                searchable: true,
                render: function(data, type, row) {
                    return moment(data).locale('id').format('ll') ?? '-';

                }
            },
            {
                data: 'alamat',
                name: 'alamat',
                orderable: false,
                searchable: false
            },
        ];
        var table = initializeDataTable(selector, route, columns);
    })
</script>
@endpush
@endsection