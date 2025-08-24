@extends('pages.layouts.guru')

@section('title', 'Data Materi Pembelajaran')
@section('description', 'Berikut adalah semua data materi pembelajaran yang telah tercatat.')

@section('content')
<section class="section">
    <a href="{{ route('guru.kelola-pembelajaran.index') }}" class="btn mb-3"><i class="bi bi-arrow-left"></i> Kembali</a>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="mb-2 row">
                    <div class="d-flex align-items-center">
                        <div class="ms-3">
                            <h3 class="mb-0 fw-bolder">Kelas {{ $dataGuruKelas->kelas->nama_kelas ?? '-' }} ({{ $dataGuruKelas->guru ? $dataGuruKelas->guru->mapel->nama_mapel : '-' }}) - {{ $dataGuruKelas->kelas->siswa->count() ?? 0 }} Siswa</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">
                    Daftar Materi Pembelajaran
                </h5>
                <button type="button" id="create" data-kelas="{{ $dataGuruKelas->kelas_id }}" data-guru="{{ $dataGuruKelas->guru_id }}" data-mapel="{{ $dataGuruKelas->guru->mapel_id }}" class="btn btn-primary block" data-bs-toggle="modal"
                    data-bs-target="#modalForm">
                    <i class="bi bi-plus me-1 fs-5"></i>Tambah Materi
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table data-table" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Materi</th>
                                <th>Tanggal Dibuat</th>
                                <th>Tanggal Terakhir</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('pages.guru.kelola-pembelajaran.create-modal')
    @include('pages.guru.kelola-pembelajaran.show-file-modal')
</section>
@push('scripts')
<script type="text/javascript">
    $(function() {
        var route = "{{ route('guru.kelola-pembelajaran.show', $dataGuruKelas->kelas_id) }}";
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

        $(document).on('click', '#create', function() {
            let guruId = $(this).data('guru');
            let kelasId = $(this).data('kelas');
            let mapelId = $(this).data('mapel');
            $('#guru_id').val(guruId);
            $('#kelas_id').val(kelasId);
            $('#mapel_id').val(mapelId);
            let formSelector = '#submitForm';
            let modal = '#modalForm';
            $(modal).find('.modal-title').html('Tambah Materi Pembelajaran');
            let actionUrl = "{{ route('guru.kelola-pembelajaran.store') }}";
            let successMessage = 'Data berhasil disimpan!';
            submitFormUploadAjaxModal(formSelector, actionUrl, successMessage, modal, table);
        });

        $(document).on('click', '#fileMateri', function() {
            $('#modalShowFile').find('.modal-title').html('Lihat Materi Pembelajaran');
            let file = $(this).data('file');
            let url = "{{ asset('storage') }}/" + file;
            $('#showFile').attr('data', url);
        });

        $(document).on('click', '#edit', function() {
            const id = $(this).data('id');
            const $modal = $('#modalForm');
            const $form = $('#submitForm');
            $($modal).find('.modal-title').html('Ubah Materi Pembelajaran');
            $form.attr('method', 'POST'); // Sementara set ke POST
            $form.append('<input type="hidden" name="_method" value="PUT">'); // Menambahkan _method untuk mengindikasikan PUT
            let actionUrl = "{{ route('guru.kelola-pembelajaran.update', ':id') }}".replace(':id', id);
            let successMessage = 'Data berhasil diubah!';
            submitFormUploadAjaxModal('#submitForm', actionUrl, successMessage, '#modalForm', table);

            $modal.modal && $modal.modal('show');

            $.ajax({
                url: "{{ route('guru.kelola-pembelajaran.edit', ':id') }}".replace(':id', id),
                method: 'GET'
            }).done(function(response) {
                const d = response.data;
                $('#nama_materi').val(d.nama_materi);
                $('#deskripsi').val(d.deskripsi);
                $('#guru_id').val(d.guru_id);
                $('#kelas_id').val(d.kelas_id);
                $('#mapel_id').val(d.mapel_id);
            }).fail(function(xhr) {
                console.error(xhr.responseText || xhr.statusText);
                alert('Gagal memuat data.');
            });
        });

        $(document).on('click', '#delete', function() {
            var id = $(this).data('id');
            var route = "{{ route('guru.kelola-pembelajaran.destroy', ':id') }}";
            route = route.replace(':id', id);
            deleteDataAjax(route, table);
        });
    })
</script>
@endpush
@endsection