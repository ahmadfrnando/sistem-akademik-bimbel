@extends('pages.layouts.admin')

@section('title', 'Data Jadwal')
@section('description', 'Berikut adalah semua data jadwal yang telah tercatat.')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">
                Semua Jadwal
            </h5>
            <a onClick="add()" href="javascript:void(0)" class="btn btn-add btn-warning block">
                <i class="bi bi-plus me-1 fs-5"></i>Tambah Jadwal
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table data-table" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Jadwal</th>
                            <th>Guru</th>
                            <th>Jam</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    @include('pages.admin.jadwal._form')
</section>
@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        var route = "{{ route('admin.jadwal.index') }}";
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
                data: 'guru_id',
                name: 'guru_id',
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
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ];
        var table = initializeDataTable(selector, route, columns);
        $('#jadwalModal').on('hidden.bs.modal', function() {
            let $form = $('#jadwalForm');

            $form[0].reset();
            $form.find('input[name="_method"]').remove(); // hapus kalau ada

            const $guru = $('#guru_id');
            if ($guru.hasClass('select2-hidden-accessible')) {
                $guru.select2('destroy');
            }

            $('#modalTitle').text('Tambah Jadwal');
        });
        $(document).on('click', '.btn-add', function() {
            let $form = $('#jadwalForm');
            let modal = '#jadwalModal';

            $form[0].reset();
            $form.find('input[name="_method"]').remove(); // pastikan _method tidak ada

            $('#modalTitle').text('Tambah Jadwal');

            $('#guru_id').select2({
                placeholder: 'Pilih Guru',
                allowClear: true,
                width: 'resolve',
                dropdownParent: $(modal),
                ajax: {
                    url: "{{ route('search.guru') }}",
                    dataType: 'json',
                    processResults: data => ({
                        results: data.map(res => ({
                            text: res.nama,
                            id: res.id
                        }))
                    })
                }
            });

            let actionUrl = "{{ route('admin.jadwal.store') }}";
            let successMessage = 'Data berhasil disimpan!';
            submitFormAjaxModal('#jadwalForm', actionUrl, successMessage, modal, table);

            $(modal).modal('show');
        });

        $(document).on('click', '#edit, .btn-edit', function() {
            const id = $(this).data('id');
            const $modal = $('#jadwalModal');
            const $form = $('#jadwalForm');
            const $guru = $('#guru_id');

            $modal.find('.modal-title').html('Ubah Jadwal');
            if ($form.find('input[name="_method"]').length === 0) {
                $form.append('<input type="hidden" name="_method" value="PUT">');
            }

            let actionUrl = "{{ route('admin.jadwal.update', ':id') }}".replace(':id', id);
            let successMessage = 'Data berhasil diubah!';
            submitFormAjaxModal('#jadwalForm', actionUrl, successMessage, '#jadwalModal', table);

            $modal.modal('show');

            // Ambil data lama
            $.ajax({
                url: "{{ route('admin.jadwal.edit', ':id') }}".replace(':id', id),
                method: 'GET'
            }).done(function(response) {
                const d = response.data;
                $('#nama_jadwal').val(d.nama_jadwal);
                $('#tanggal').val(d.tanggal);
                $('#keterangan').val(d.keterangan);
                $('#jam_mulai').val(d.jam_mulai);
                $('#jam_masuk').val(d.jam_masuk);

                // Init select2 dengan data existing
                if ($guru.hasClass('select2-hidden-accessible')) {
                    $guru.select2('destroy');
                }

                $guru.select2({
                    placeholder: 'Pilih Guru',
                    allowClear: true,
                    width: '100%',
                    dropdownParent: $modal,
                    data: d.guru ? [{
                        id: d.guru.id,
                        text: d.guru.nama
                    }] : [],
                    ajax: {
                        url: "{{ route('search.guru') }}",
                        dataType: 'json',
                        delay: 250,
                        data: params => ({
                            q: params.term || ''
                        }),
                        processResults: data => ({
                            results: data.map(res => ({
                                id: res.id,
                                text: res.nama
                            }))
                        }),
                        cache: true
                    }
                });

                if (d.guru_id && d.guru && d.guru.nama) {
                    const option = new Option(d.guru.nama, d.guru_id, true, true);
                    $guru.append(option).trigger('change');
                } else {
                    $guru.val(null).trigger('change');
                }
            }).fail(function(xhr) {
                console.error(xhr.responseText || xhr.statusText);
                alert('Gagal memuat data.');
            });
        });


        $(document).on('click', '#delete', function() {
            var id = $(this).data('id');
            var route = "{{ route('admin.jadwal.destroy', ':id') }}";
            route = route.replace(':id', id);
            deleteDataAjax(route, table);
        });
    })
</script>
@endpush
@endsection