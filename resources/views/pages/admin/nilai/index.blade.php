@extends('pages.layouts.admin')

@section('title', 'Nilai Siswa')
@section('description', 'Berikut adalah semua data nilai siswa yang telah tercatat.')

@section('content')
@push('styles')
<style>
    .nav-tabs .nav-link.active,
    .nav-tabs .nav-item.show .nav-link {
        color: #ffc107 !important;
        background-color: #fffaf2ff !important;
    }

    .nav-tabs .nav-link.active:after {
        background-color: #ffc107 !important;
    }

    .nav {
        color: #ffc107 !important;
    }
</style>
@endpush
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">
                Semua Nilai Siswa
            </h5>
            <div>
                <a href="{{ route('admin.nilai.cetak', 1) }}" target="_blank" rel="noopener noreferrer">
                    <button type="button" id="create" class="btn btn-add btn-primary block">
                        <i class="bi bi-printer me-1 fs-5"></i>Cetak Nilai Semester 1
                    </button>
                </a>
                <a href="{{ route('admin.nilai.cetak', 2) }}" target="_blank" rel="noopener noreferrer">
                    <button type="button" id="create" class="btn btn-add btn-primary block">
                        <i class="bi bi-printer me-1 fs-5"></i>Cetak Nilai Semester 2
                    </button>
                </a>
            </div>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="semester-satu-tab" data-bs-toggle="tab" href="#semester-satu" role="tab"
                        aria-controls="semester-satu" aria-selected="true">Semester I</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="semester-dua-tab" data-bs-toggle="tab" href="#semester-dua" role="tab"
                        aria-controls="semester-dua" aria-selected="false">Semester II</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active my-2" id="semester-satu" role="tabpanel" aria-labelledby="semester-satu-tab">
                    @include('pages.admin.nilai._show_semester_satu')
                </div>
                <div class="tab-pane fade" id="semester-dua" role="tabpanel" aria-labelledby="semester-dua-tab">
                    @include('pages.admin.nilai._show_semester_dua')
                </div>
            </div>
        </div>
    </div>
</section>
@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        var route = "{{ route('admin.nilai.index') }}";
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
                data: 'user_id',
                name: 'user_id',
            },
            {
                data: 'tgl_lahir',
                name: 'tgl_lahir',
                render: function(data, type, row) {
                    return moment(data).locale('id').format('ll') ?? '-';
                }
            },
            {
                data: 'alamat',
                name: 'alamat',
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