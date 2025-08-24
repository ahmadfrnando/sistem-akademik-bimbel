<div class="d-flex align-items-center">
    <a href="javascript:void(0)" onClick="showSubmissionFunc({{ $id }})" class="btn btn-lihat btn-secondary btn-sm text-nowrap me-2" data-toggle="tooltip" data-placement="bottom" title="Submissions"><i class="bi bi-eye"></i></a></a>
    <a href="javascript:void(0)" onClick="deleteFunc({{ $id }})" class="btn btn-danger btn-sm me-2" data-toggle="tooltip" data-placement="bottom" title="Hapus"><i class="bi bi-trash"></i></a>
    <a href="{{ route('guru.tugas.show', $id) }}" class="btn btn-outline-warning btn-sm" data-toggle="tooltip" data-placement="bottom" title="Detail">Detail</a>
</div>