@extends('pages.layouts.guru')

@section('title', 'UsernameAkun Pengguna')
@section('description', '')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Ubah Username</h4>
        </div>
        <div class="card-body">
            <form id="updateForm">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="username">Username Baru</label>
                            <input type="text" class="form-control" name="username" id="username" placeholder="Masukkan Password Baru Anda">
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary" id="update">Ubah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@push('scripts')
<script type="text/javascript">
    $(function() {
        let formSelector = '#updateForm';
        let actionUrl = "{{ route('guru.user.update-username') }}";
        let successMessage = 'Data berhasil diubah!';
        submitFormAjaxModal(formSelector, actionUrl, successMessage);
    })
</script>
@endpush
@endsection