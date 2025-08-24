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
    });


    function add() {
        $('#jadwalForm')[0].reset();
        $('.modal-title').html("Tambah Jadwal");
        $('#jadwalModal').modal('show');
        $('#id').val('');
        $('#guru_id').val(null).trigger('change');
        $('#guru_id').select2({
            placeholder: 'Pilih Guru',
            allowClear: true,
            width: 'resolve',
            dropdownParent: $('#jadwalModal'),
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
    }

    function editFunc(id) {
        var id = id;
        $.ajax({
            type: "GET",
            url: "{{ route('admin.jadwal.edit') }}",
            data: {
                id: id
            },
            dataType: 'json',
            success: function(response) {
                const d = response.data;
                const g = response.guru;
                console.log(g);
                $('.modal-title').html("Edit Jadwal");
                $('#jadwalModal').modal('show');
                $('#nama_jadwal').val(d.nama_jadwal);
                $('#tanggal').val(d.tanggal);
                $('#keterangan').val(d.keterangan);
                $('#jam_mulai').val(convertHisToHi(d.jam_mulai));
                $('#jam_selesai').val(convertHisToHi(d.jam_selesai));
                $('#id').val(id);

                let $modal = $('#jadwalModal');
                let $guru = $('#guru_id');

                if ($guru.hasClass('select2-hidden-accessible')) {
                    $guru.select2('destroy');
                }

                $guru.select2({
                    placeholder: 'Pilih Guru',
                    allowClear: true,
                    width: '100%',
                    dropdownParent: $modal,
                    data: g ? [{
                        id: g.id,
                        text: g.nama
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

                if (g && g.nama) {
                    const option = new Option(g.nama, g.id, true, true);
                    $guru.append(option).trigger('change');
                } else {
                    $guru.val(null).trigger('change');
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
                    url: "{{ route('admin.jadwal.destroy') }}",
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

    $('#jadwalForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: "{{ route('admin.jadwal.store') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                $("#jadwalModal").modal('hide');
                var oTable = $('.data-table').dataTable();
                oTable.fnDraw(false);
                $("#btn-save").html('Submit');
                $("#btn-save").attr("disabled", false);
                showToast('success', data.message);
            },
            error: function(data) {
                showToast('error', 'Data gagal disimpan' + data.responseJSON.message);
                console.log(data);
            }
        });
    });
</script>
@endpush
@endsection