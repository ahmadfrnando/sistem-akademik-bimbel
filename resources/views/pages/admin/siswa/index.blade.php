@extends('pages.layouts.admin')

@section('title', 'Data Siswa')
@section('description', 'Berikut adalah semua data siswa yang telah tercatat.')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">
                Semua Siswa
            </h5>
            <div>
                <a href="{{ route('admin.siswa.cetak') }}" target="_blank" rel="noopener noreferrer">
                    <button type="button" id="create" class="btn btn-add btn-primary block">
                        <i class="bi bi-printer me-1 fs-5"></i>Cetak Data Siswa
                    </button>
                </a>
                <button type="button" id="create" class="btn btn-add btn-warning block" data-bs-toggle="modal" data-bs-target="#modalForm">
                    <i class="bi bi-plus me-1 fs-5"></i>Tambah Siswa
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table data-table" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Akun</th>
                            <th>Tanggal Lahir</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    @include('pages.admin.siswa._form')
    @include('pages.admin.siswa.akun._edit-username')
    @include('pages.admin.siswa.akun._edit-password')
</section>
@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        var route = "{{ route('admin.siswa.index') }}";
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

        $(document).on('click', '#create', function() {
            let formSelector = '#submitForm';
            $(formSelector).find('input[name="nama"]').focus();
            let modal = '#modalForm';
            $(modal).find('.modal-title').html('Tambah Siswa');
            let actionUrl = "{{ route('admin.siswa.store') }}";
            let successMessage = 'Data berhasil disimpan!';
            submitFormAjaxModal(formSelector, actionUrl, successMessage, modal);
        })

        $(document).on('click', '#edit, .btn-edit', function() {
            const id = $(this).data('id');
            const $modal = $('#modalForm');
            const $form = $('#submitForm');
            const $kelas = $('#kelas_id');
            $($modal).find('.modal-title').html('Ubah Siswa');

            $form.attr('method', 'POST'); // Sementara set ke POST
            $form.append('<input type="hidden" name="_method" value="PUT">'); // Menambahkan _method untuk mengindikasikan PUT


            let actionUrl = "{{ route('admin.siswa.update', ':id') }}".replace(':id', id);
            let successMessage = 'Data berhasil diubah!';
            submitFormAjaxModal('#submitForm', actionUrl, successMessage, '#modalForm', table);

            $modal.modal && $modal.modal('show');

            $.ajax({
                url: "{{ route('admin.siswa.edit', ':id') }}".replace(':id', id),
                method: 'GET'
            }).done(function(response) {
                const d = response.data;
                $('#nama').val(d.nama);
                $('#tgl_lahir').val(d.tgl_lahir);
                $('#alamat').val(d.alamat);
            }).fail(function(xhr) {
                console.error(xhr.responseText || xhr.statusText);
                alert('Gagal memuat data.');
            });
        });

        $(document).on('click', '#updatePassword', function() {
            const id = $(this).data('id');
            const $modal = $('#modalUpdatePasswordForm');
            const $form = $('#submitUpdatePasswordForm');

            $form.attr('method', 'POST'); // Sementara set ke POST
            $form.append('<input type="hidden" name="_method" value="PUT">'); // Menambahkan _method untuk mengindikasikan PUT

            let actionUrl = "{{ route('admin.password.update', ':id') }}".replace(':id', id);
            let successMessage = 'Data berhasil diubah!';
            submitFormAjaxModal('#submitUpdatePasswordForm', actionUrl, successMessage, '#modalUpdatePasswordForm', table);
        });

        $(document).on('click', '#updateAkun', function() {
            const id = $(this).data('id');
            const $modal = $('#modalUpdateAkunForm');
            const $form = $('#submitUpdateAkunForm');

            $form.attr('method', 'POST'); // Sementara set ke POST
            $form.append('<input type="hidden" name="_method" value="PUT">'); // Menambahkan _method untuk mengindikasikan PUT

            let actionUrl = "{{ route('admin.akun.update', ':id') }}".replace(':id', id);
            let successMessage = 'Data berhasil diubah!';
            submitFormAjaxModal('#submitUpdateAkunForm', actionUrl, successMessage, '#modalUpdateAkunForm', table);

            $.ajax({
                url: "{{ route('admin.akun.edit', ':id') }}".replace(':id', id),
                method: 'GET'
            }).done(function(response) {
                const d = response.data;

                $('#name').val(d.name);
                $('#username').val(d.username);
            }).fail(function(xhr) {
                console.error(xhr.responseText || xhr.statusText);
                alert('Gagal memuat data.');
            });
        });

        $(document).on('click', '#delete', function() {
            var id = $(this).data('id');
            var route = "{{ route('admin.siswa.destroy', ':id') }}";
            route = route.replace(':id', id);
            deleteDataAjax(route, table);
        });
    })
</script>
@endpush
@endsection