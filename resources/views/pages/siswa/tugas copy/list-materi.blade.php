@extends('pages.layouts.siswa')

@section('title', 'Daftar Materi')
@section('description', 'Berikut adalah semua daftar materi pembelajaran yang telah tercatat.')

@section('content')
<section class="section">
    <a href="{{ route('siswa.tugas.index') }}" class="btn mb-3"><i class="bi bi-arrow-left"></i> Kembali</a>
    <div class="card">
        <div class="card-body">
            <div class="mb-2 row">
                <div class="d-flex align-items-center">
                    <div class="ms-3">
                        <h3 class="mb-0 fw-bolder">{{ $guruKelas->mapel->nama_mapel }}</h3>
                        <div class="d-flex gap-4 mt-2 align-items-center justify-content-start">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-briefcase text-muted me-1 lh-1"></i>
                                <span class="text-muted">Kelas: {{ $guruKelas->kelas->nama_kelas }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-person text-muted me-1 lh-1"></i>
                                <span class="text-muted">Nama Guru Pengampu: {{ $guruKelas->guru->nama ?? '-' }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-card-checklist text-muted me-1 lh-1"></i>
                                <span class="text-muted">Total Materi Pembelajaran: {{ $dataCount ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                Semua Materi
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table data-table" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Tugas</th>
                            <th>Tanggal Dibuat</th>
                            <th>Deadline</th>
                            <th>Status Tugas</th>
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
    $(function() {
        var route = "{{ route('siswa.tugas.list-materi', $mapel_id) }}";
        var selector = ".data-table";
        var columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                className: 'w-8 text-center text-sm',
                orderable: false,
                searchable: false
            },
            {
                data: 'nama_materi',
                name: 'nama_materi',
                orderable: true,
                searchable: true
            },
            {
                data: 'created_at',
                name: 'created_at',
                render: function(data, type, row) {
                    return moment(data).locale('id').format('ll') ?? '-';
                }
            },
            {
                data: 'tanggal_deadline',
                name: 'tanggal_deadline',
                render: function(data, type, row) {
                    return moment(data).locale('id').format('ll') ?? '-';
                }
            },
            {
                data: 'status',
                name: 'status',
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ];
        var table = initializeDataTable(selector, route, columns);
    })
</script>
@endpush
@endsection