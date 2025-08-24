<div class="modal fade text-left" id="jadwalModal" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel4" data-bs-backdrop="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel4"></h4>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form action="javascript:void(0)" id="jadwalForm" name="jadwalForm" class="form-horizontal"
                method="POST">
                @csrf
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="nama_jadwal">Nama Jadwal</label>
                            <input type="text" class="form-control" name="nama_jadwal" id="nama_jadwal" oninput="capitalizeWords(this);" required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" id="tanggal" required>
                        </div>
                        <div class="col-12 mb-4">
                            <label for="guru_id">Nama Guru</label>
                            <select id="guru_id" name="guru_id" style="width: 100%; height: 100%" required>
                            </select>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="jam_mulai">Jam Mulai</label>
                            <input type="time" class="form-control" name="jam_mulai" id="jam_mulai" required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="jam_selesai">Jam Selesai</label>
                            <input type="time" class="form-control" name="jam_selesai" id="jam_selesai" required>
                        </div>
                        <div class="col-12 mb-4">
                            <label for="keterangan">Keterangan</label>
                            <textarea rows="4" class="form-control" name="keterangan" id="keterangan" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary"
                        data-bs-dismiss="modal">
                        <i class="bi bi-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                    <button type="submit" id="btn-save" class="btn btn-primary ms-1">
                        <i class="bi bi-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>