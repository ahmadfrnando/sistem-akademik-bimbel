@extends('pages.layouts.guru')

@section('title', 'Password Akun Pengguna')
@section('description','')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Ubah Password</h4>
        </div>
        <div class="card-body">
            <form id="updateForm">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Password Baru</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan Password Baru Anda">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Masukkan Konfirmasi Password Baru Anda">
                        </div>
                    </div>
                    <div class="col-12 text-end">
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
        let actionUrl = "{{ route('guru.user.update-password') }}";
        let successMessage = 'Data berhasil diubah!';
        submitFormAjaxModal(formSelector, actionUrl, successMessage);
    })
</script>
@endpush
@endsection