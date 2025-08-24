<div class="modal fade text-left" id="modalForm" tabindex="-1" role="dialog"
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
            <form action="javascript:void(0)" id="submitForm" name="submitForm" class="form-horizontal"
                method="POST">
                @csrf
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="guru_id" id="guru_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <label for="jadwal_id">Jadwal</label>
                            <select id="jadwal_id" name="jadwal_id" style="width: 100%; height: 100%" required>
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="judul" class="form-label">Judul Tugas</label>
                            <input class="form-control" name="judul" type="text" id="judul">
                        </div>
                        <div class="col-12 mb-4">
                            <label for="kategori_tugas_id">Kategori Tugas</label>
                            <select id="kategori_tugas_id" name="kategori_tugas_id" class="form-control" required>
                                <option value="" disabled selected>- Pilih -</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}">{{ $item->kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mb-4">
                            <label for="keterangan">Keterangan</label>
                            <textarea rows="4" class="form-control" name="keterangan" id="keterangan"></textarea>
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