@extends('pages.layouts.guru')

@section('title', 'Input Soal Tugas')
@section('description', 'Form untuk menambahkan soal pilihan ganda.')

@section('content')
<section class="section">
    <a href="{{ route('guru.tugas.index') }}" class="btn mb-3">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                <div>
                    <h3 class="mb-1 fw-bolder">{{ $data->judul }}</h3>
                    <div class="text-muted">
                        Tanggal: {{ \Carbon\Carbon::parse($data->jadwal->tanggal ?? '')->format('d-m-Y') }}
                    </div>
                    <div class="text-muted">
                        Jadwal: {{ \Carbon\Carbon::parse($data->jadwal->jam_mulai ?? '')->format('H:i') }} - {{ \Carbon\Carbon::parse($data->jadwal->jam_selesai ?? '')->format('H:i') }}
                    </div>
                    <div class="small text-muted mt-2">
                        Keterangan: {{ $data->keterangan ?: '-' }}
                    </div>
                </div>
                @if($data->is_draft == true && $data->pertanyaan->count() > 0)
                <div class="d-flex align-items-center gap-2 ms-auto">
                    <a href="javascript:void(0)" onClick="sendFunc({{ $data->id }})" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="Kirim Tugas">
                        <i class="bi bi-send-check"></i> Kirim Tugas
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="card-title mb-0">
                Tambah Pertanyaan Pilihan Ganda
            </h5>
        </div>
        <div class="card-body">
            <form id="formSoal">
                @csrf
                <input type="hidden" name="tugas_id" value="{{ $data->id }}">
                <div class="mb-3">
                    <label for="pertanyaan" class="form-label">Pertanyaan</label>
                    <textarea name="pertanyaan" id="pertanyaan" class="form-control" rows="3" required></textarea>
                </div>

                <div class="mb-3 col-md-3">
                    <label for="bobot" class="form-label">Bobot</label>
                    <input type="number" class="form-control" name="bobot" id="bobot" min="1" required>
                </div>

                <hr>
                <h6 class="mb-3">Opsi Jawaban</h6>
                <div id="opsi-container">
                    <!-- Opsi akan di-generate oleh JS -->
                </div>
                <button type="button" class="btn btn-sm btn-outline-success mb-3" onclick="addOpsi()">
                    + Tambah Opsi
                </button>
                <hr>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Simpan Soal</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card shadow-sm mt-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Pertanyaan yang Telah Disimpan</h5>
        </div>
        <div class="card-body">
            @if($data->pertanyaan->isEmpty())
            <p class="text-muted">Belum ada pertanyaan yang disimpan.</p>
            @else
            @foreach($data->pertanyaan as $p)
            <div class="card mb-3 border">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><strong>Pertanyaan:</strong> {{ $p->pertanyaan }}</span>
                    <span class="badge bg-primary">Bobot: {{ $p->bobot }}</span>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-hover">
                        <thead class="table-light">
                            <tr>
                                <th style="width:5%">#</th>
                                <th style="width:10%">Label</th>
                                <th>Opsi Jawaban</th>
                                <th style="width:15%">Kebenaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($p->opsi as $idx => $opsi)
                            <tr>
                                <td>{{ $idx+1 }}</td>
                                <td>{{ strtoupper($opsi->label) }}</td>
                                <td>{{ $opsi->text }}</td>
                                <td>
                                    @if($opsi->is_correct)
                                    <span class="badge bg-success">Benar</span>
                                    @else
                                    <span class="badge bg-danger">Salah</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer  d-flex justify-content-end">
                    <a href="javascript:void(0)" onClick="deleteFunc({{ $p->id }})" class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Hapus Pertanyaan">
                        Hapus
                    </a>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    let opsiIndex = 0;
    const labels = ['a', 'b', 'c', 'd', 'e', 'f'];

    function addOpsi() {
        if (opsiIndex >= labels.length) {
            alert("Batas maksimal opsi tercapai");
            return;
        }

        let container = document.getElementById('opsi-container');

        let card = document.createElement('div');
        card.className = "card mb-2 border";

        card.innerHTML = `
            <div class="card-body row g-2 align-items-center">
                <div class="col-md-1">
                    <label class="form-label mb-0">Label</label>
                    <select name="opsi[${opsiIndex}][label]" class="form-select form-select-sm" required>
                        <option value="${labels[opsiIndex]}" selected>${labels[opsiIndex].toUpperCase()}</option>
                    </select>
                </div>
                <div class="col-md-7">
                    <label class="form-label mb-0">Teks Opsi</label>
                    <input type="text" name="opsi[${opsiIndex}][text]" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label mb-0">Benar?</label><br>
                    <input type="radio" name="is_correct" value="${opsiIndex}" class="form-check-input">
                </div>
                <div class="col-md-1 text-end">
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeOpsi(this)">x</button>
                </div>
            </div>
        `;

        container.appendChild(card);
        opsiIndex++;
    }

    function removeOpsi(btn) {
        btn.closest('.card').remove();
    }

    // Tambahkan 4 opsi default (a–d)
    document.addEventListener("DOMContentLoaded", () => {
        for (let i = 0; i < 4; i++) addOpsi();
    });

    let formSelector = '#formSoal';
    let actionUrl = "{{ route('guru.pertanyaan.store') }}";
    let successMessage = 'Data berhasil disimpan!';
    var redirectUrl = "{{ route('guru.tugas.show', $data->id) }}";
    submitFormAjax(formSelector, actionUrl, successMessage, redirectUrl);

    function sendFunc(id) {
        $.ajax({
            url: "{{ route('guru.tugas.send') }}",
            type: "POST",
            data: {
                id: id
            },
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: successMessage || `${response.message}`,
                    confirmButtonText: 'Oke',
                    confirmButtonColor: '#5e72e4'
                }).then((result) => {
                    if (result.isConfirmed && redirectUrl) {
                        window.location.href = redirectUrl;
                    }
                });
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let res = xhr.responseJSON;
                    let errorMessages = Object.values(res.errors).flat().join('\n');
                    Swal.fire('Validasi Gagal', errorMessages, 'error');
                } else {
                    Swal.fire('Gagal', xhr.responseJSON?.message || 'Terjadi kesalahan.', 'error');
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
                    url: "{{ route('guru.pertanyaan.destroy') }}",
                    method: 'POST',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (result.isConfirmed && redirectUrl) {
                            window.location.href = redirectUrl;
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let res = xhr.responseJSON;
                            let errorMessages = Object.values(res.errors).flat().join('\n');
                            Swal.fire('Validasi Gagal', errorMessages, 'error');
                        } else {
                            Swal.fire('Gagal', xhr.responseJSON?.message || 'Terjadi kesalahan.', 'error');
                        }
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
</script>
@endpush