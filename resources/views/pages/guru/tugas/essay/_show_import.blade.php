<div class="modal fade text-left" id="modalFormImportEssay" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel4" data-bs-backdrop="false" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-show-title" id="myModalLabel4">Import Tugas</h4>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form action="javascript:void(0)" id="submitFormImportEssay" name="submitFormImportEssay" class="form-horizontal"
                method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <a href="{{ asset('template/_template_tugas_essay.xlsx') }}" class="btn btn-warning btn-sm text-nowrap" download="template-tugas-essay.xlsx">
                            <i class="bi bi-box-arrow-in-down"></i>
                            <span>Unduh Template Essay</span>
                        </a>
                    </div>
                    <input class="form-control" type="number" name="tugas_id" id="tugas_id_essay" hidden readonly>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Upload File</label>
                        <input class="form-control" type="file" name="file" id="formFile">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary"
                        data-bs-dismiss="modal">
                        <i class="bi bi-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                    <button type="submit" id="btn-save" class="btn btn-warning ms-1">
                        <i class="bi bi-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>