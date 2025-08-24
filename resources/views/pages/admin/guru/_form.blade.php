<div class="modal fade text-left" id="modalForm" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel4" data-bs-backdrop="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
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
                    <div class="mb-4">
                        <label for="nama">Nama Guru</label>
                        <input type="text" class="form-control" name="nama" id="nama" placeholder="Jhon Doe" oninput="capitalizeWords(this);" required>
                    </div>
                    <div class="mb-4">
                        <label for="tgl_lahir">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir" required>
                    </div>
                    <div class="mb-4">
                        <label for="alamat">Alamat</label>
                        <textarea rows="4" type="date" class="form-control" name="alamat" id="alamat" oninput="capitalizeWords(this);" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary"
                        data-bs-dismiss="modal">
                        <i class="bi bi-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                    <button type="submit" class="btn btn-primary ms-1">
                        <i class="bi bi-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>