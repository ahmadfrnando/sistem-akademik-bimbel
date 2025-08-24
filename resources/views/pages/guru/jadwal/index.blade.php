@extends('pages.layouts.guru')

@section('title', 'Data Jadwal')
@section('description`', 'Berikut adalah semua data jadwal yang telah tercatat.')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                Semua Jadwal
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table data-table" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Jadwal</th>
                            <th>Jam</th>
                            <th>Keterangan</th>
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
        var route = "{{ route('guru.jadwal.index') }}";
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
                    return moment(data).locale('id').format('ll') ?? '-';
                }
            },
            {
                data: 'nama_jadwal',
                name: 'nama_jadwal',
                orderable: true,
                searchable: true
            },
            {
                data: 'jam',
                name: 'jam',
            },
            {
                data: 'keterangan',
                name: 'keterangan',
                className: 'w-20',
            },
        ];
        var table = initializeDataTable(selector, route, columns);
    });
</script>
@endpush
@endsection