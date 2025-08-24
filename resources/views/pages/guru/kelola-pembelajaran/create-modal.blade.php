<div class="modal fade text-left" id="modalForm" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel4" data-bs-backdrop="false" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel4"></h4>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form id="submitForm">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="guru_id" id="guru_id" readonly>
                    <input type="hidden" name="kelas_id" id="kelas_id" readonly>
                    <input type="hidden" name="mapel_id" id="mapel_id" readonly>
                    <div class="form-group mb-4">
                        <label for="nama_materi">Nama Materi</label>
                        <input type="text" name="nama_materi" class="form-control" id="nama_materi" oninput="capitalizeWords(this);" placeholder="Masukan Nama Materi" reqiured>
                    </div>
                    <div class="form-group mb-4">
                        <label for="tanggal_deadline">Tanggal Deadline</label>
                        <input type="date" name="tanggal_deadline" class="form-control" id="tanggal_deadline" reqiured>
                    </div>
                    <div class="mb-3">
                        <label for="file_materi" class="form-label">File</label>
                        <small class="text-muted"><i>pdf maksimal 2MB</i></small>
                        <input class="form-control" name="file_materi" type="file" id="file_materi">
                    </div>
                    <div class="form-group mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary"
                        data-bs-dismiss="modal">
                        <i class="bi bi-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                    <button type="submit" id="btnSubmit" class="btn btn-primary ms-1">
                        <i class="bi bi-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>