@extends('pages.layouts.guru')

@section('title', 'Data Pembelajaran')
@section('description', 'Berikut adalah semua data pembelajaran yang telah tercatat.')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">
                Semua Pembelajaran
            </h5>
            <a onClick="add()" href="javascript:void(0)" class="btn btn-add btn-warning block">
                <i class="bi bi-plus me-1 fs-5"></i>Tambah Pembelajaran
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table data-table" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Judul Pembelajaran</th>
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
    @include('pages.guru.pembelajaran._form')
    @include('pages.guru.pembelajaran._show')
</section>
@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        var route = "{{ route('guru.pembelajaran.index') }}";
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
                data: 'judul',
                name: 'judul',
                orderable: true,
                searchable: true
            },
            {
                data: 'jam',
                name: 'jam',
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
    });


    function add() {
        $('#submitForm')[0].reset();
        $('.modal-title').html("Tambah Pembelajaran");
        $('#modalForm').modal('show');
        $('#id').val('');
        $('#guru_id').val('{{ $guru_id }}');
        $('#jadwal_id').val(null).trigger('change');
        $('#jadwal_id').select2({
            placeholder: 'Pilih Jadwal',
            allowClear: true,
            width: 'resolve',
            dropdownParent: $('#modalForm'),
            ajax: {
                url: "{{ route('search.jadwal.pembelajaran') }}",
                dataType: 'json',
                processResults: data => ({
                    results: data.map(res => ({
                        text: res.text,
                        id: res.id
                    }))
                })
            }
        });
    }

    function showFunc(fileParams) {
        console.log('test');
        $('#modalShow').modal('show');
        var file = fileParams;
        $('#modalShowFile').find('.modal-title').html('Lihat Lampiran');
        let url = "{{ asset('storage') }}/" + file;
        $('#showFile').attr('data', url);
        $('#modalShowFile').modal('show');
    }

    function editFunc(id) {
        var id = id;
        $.ajax({
            type: "GET",
            url: "{{ route('guru.pembelajaran.edit') }}",
            data: {
                id: id
            },
            dataType: 'json',
            success: function(response) {
                const d = response.data;
                const j = response.jadwal;
                console.log(j);
                $('.modal-title').html("Edit Pembelajaran");
                $('#modalForm').modal('show');
                $('#judul').val(d.judul);
                $('#keterangan').val(d.keterangan);
                $('#guru_id').val(d.guru_id);
                $('#id').val(id);

                let $modal = $('#modalForm');
                let $jadwal = $('#jadwal_id');

                if ($jadwal.hasClass('select2-hidden-accessible')) {
                    $jadwal.select2('destroy');
                }

                $jadwal.select2({
                    placeholder: 'Pilih Jadwal',
                    allowClear: true,
                    width: '100%',
                    dropdownParent: $modal,
                    data: j ? [{
                        id: j.id,
                        text: j.nama_jadwal + ' - ' + j.tanggal + ' (' + (j.jam_mulai ? j.jam_mulai : '') + ' - ' + (j.jam_selesai ? j.jam_selesai : '') + ')'
                    }] : [],
                    ajax: {
                        url: "{{ route('search.jadwal.pembelajaran') }}",
                        dataType: 'json',
                        delay: 250,
                        data: params => ({
                            q: params.term || ''
                        }),
                        processResults: data => ({
                            results: data.map(res => ({
                                id: res.id,
                                text: res.text
                            }))
                        }),
                        cache: true
                    }
                });

                if (j && j.nama_jadwal) {
                    const option = new Option(j.nama_jadwal, j.id, true, true);
                    $jadwal.append(option).trigger('change');
                } else {
                    $jadwal.val(null).trigger('change');
                }
            }
        });
    }

    function deleteFunc(id) {
        var id = id;
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('guru.pembelajaran.destroy') }}",
                    method: 'POST',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        var oTable = $('.data-table').dataTable();
                        oTable.fnDraw(false);
                        showToast('success', response.message);
                    },
                    error: function(xhr) {
                        showToast('error', xhr.responseJSON?.message);
                    }
                }).always(function() {
                    $.ajaxSetup({
                        headers: {}
                    });
                });
            }
        }).catch(function(e) {
            e.preventDefault();
        });
    }
    $('#submitForm').submit(function(e) {
        e.preventDefault();
        $("#btn-save").prop('disabled', true);
        $("#btn-save").html('Menyimpan... <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: "{{ route('guru.pembelajaran.store') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                $("#modalForm").modal('hide');
                var oTable = $('.data-table').dataTable();
                oTable.fnDraw(false);
                $("#btn-save").prop('disabled', false);
                $("#btn-save").html('Simpan');
                showToast('success', data.message);
            },
            error: function(data) {
                $("#btn-save").prop('disabled', false);
                $("#btn-save").html('Simpan');
                showToast('error', 'Data gagal disimpan. ' + data.responseJSON.message);
                console.log(data);
            },
        });
    });
</script>
@endpush
@endsection