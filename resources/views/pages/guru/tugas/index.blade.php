@extends('pages.layouts.guru')

@section('title', 'Data Tugas')
@section('description', 'Berikut adalah semua data tugas yang telah tercatat.')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">
                Semua Tugas
            </h5>
            <a onClick="add()" href="javascript:void(0)" class="btn btn-add btn-warning block">
                <i class="bi bi-plus me-1 fs-5"></i>Tambah Tugas
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table data-table" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Tugas</th>
                            <th>Kategori Tugas</th>
                            <th>Jam</th>
                            <th>Total Jawaban</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    @include('pages.guru.tugas._form')
    @include('pages.guru.tugas._show_submissions')
</section>
@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        var route = "{{ route('guru.tugas.index') }}";
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
                data: 'kategori',
                name: 'kategori',
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
                data: 'total_jawaban',
                name: 'total_jawaban'
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


    function add() {
        $('#submitForm')[0].reset();
        $('.modal-title').html("Tambah Tugas");
        $('#modalForm').modal('show');
        $('#id').val('');
        $('#kategori_tugas_id').val(null).trigger('change');
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

    function showSubmissionFunc(id) {
        $('#modalShow').modal('show');
        var oTable = $('.data-table-show').dataTable();
        oTable.fnDraw(false);
        var route = "{{ route('guru.tugas.submissions', ':id') }}";
        route = route.replace(':id', id);
        var selector = ".data-table-show";
        var columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                className: 'w-8 text-center text-sm',
                orderable: false,
                searchable: false
            },
            {
                data: 'siswa',
                name: 'siswa',
                orderable: true,
                searchable: true
            },
            {
                data: 'nilai',
                name: 'nilai',
                orderable: true,
                searchable: true
            },
            {
                data: 'created-at',
                name: 'created-at',
                render: function(data, type, row) {
                    return moment(data).locale('id').format('ll') ?? '-';
                }
            },
        ];
        var table = initializeDataTable(selector, route, columns);
    }

    function editFunc(id) {
        console.log('edit diklik:' + id);
        $.ajax({
            type: "GET",
            url: "{{ route('guru.tugas.edit') }}",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log("=== Response dari server ===");
                console.log(response);
                const d = response.data;
                const j = response.jadwal;
                $('.modal-title').html("Edit Tugas");
                $('#modalForm').modal('show');
                $('#id').val(id);
                $('#guru_id').val(response.data.guru_id);
                $('#judul').val(response.data.judul);
                $('#keterangan').val(response.data.keterangan);
                $('#kategori_tugas_id').val(response.data.kategori_tugas_id).trigger('change');

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
                    data: response.jadwal ? [{
                        id: response.jadwal.id,
                        text: response.jadwal.nama_jadwal + ' - ' + response.jadwal.tanggal + ' (' + (response.jadwal.jam_mulai ? response.jadwal.jam_mulai : '') + ' - ' + (response.jadwal.jam_selesai ? response.jadwal.jam_selesai : '') + ')'
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

                if (response.jadwal && response.jadwal.id) {
                    const option = new Option(response.jadwal.nama_jadwal + ' - ' + response.jadwal.tanggal + ' (' + (response.jadwal.jam_mulai ? response.jadwal.jam_mulai : '') + ' - ' + (response.jadwal.jam_selesai ? response.jadwal.jam_selesai : '') + ')', response.jadwal.id, true, true);
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
                    url: "{{ route('guru.tugas.destroy') }}",
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
        let form = $(this);
        $.ajax({
            type: 'POST',
            url: "{{ route('guru.tugas.store') }}",
            data: form.serialize(),
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: (res) => {
                $("#modalForm").modal('hide');
                var oTable = $('.data-table').dataTable();
                oTable.fnDraw(false);
                $("#btn-save").prop('disabled', false);
                $("#btn-save").html('Simpan');
                showToast('success', res.message);
            },
            error: function(xhr) {
                $("#btn-save").prop('disabled', false);
                $("#btn-save").html('Simpan');
                if (xhr.status === 422) {
                    let res = xhr.responseJSON;
                    let errorMessages = Object.values(res.errors).flat().join('\n');
                    showToast('error', 'Data gagal disimpan\n' + errorMessages);
                } else {
                    showToast('error', 'Data gagal disimpan\n' + xhr.responseJSON?.message || 'Terjadi kesalahan.');
                }
            },
        });
    });
</script>
@endpush
@endsection