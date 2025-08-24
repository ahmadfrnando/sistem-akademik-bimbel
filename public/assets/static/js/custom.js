function submitFormAjax(formSelector, actionUrl, successMessage, redirectUrl) {
    $(formSelector).on('submit', function(e) {
        e.preventDefault();
        
        let form = $(this);
        $.ajax({
            url: actionUrl,
            method: 'POST',
            data: form.serialize(),
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
        })
    });
}

function submitFormUploadAjaxNoReload(formSelector, actionUrl, contentSelector, reloadUrl) {
    $(formSelector).on('submit', function(e) {
        e.preventDefault();
        
        let form = $(this);
        let formData = new FormData(form[0]);
        $.ajax({
            url: actionUrl,
            method: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            contentType: false, // Jangan set content-type secara manual, biarkan FormData yang mengaturnya
            processData: false,
            success: function(response) {
                $(formSelector)[0].reset();
                $.ajax({
                    url: reloadUrl,
                    success: function (html) {
                        $(contentSelector).html(html);
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
        })
    });
}

// Deklarasi global toast mixin sekali saja
// Fungsi helper agar lebih mudah dipanggil
function showToast(icon='error', message) {
    const toastMixin = Swal.mixin({
        toast: true,
        animation: false,
        position: 'top-right',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });
    toastMixin.fire({
        icon: icon,
        title: message
    });
}
// showToast('success', 'Data berhasil disimpan');

function submitFormAjaxModal(formSelector, actionUrl, successMessage) {
    $(formSelector).on('submit', function(e) {
        e.preventDefault();
        let form = $(this);    
        $.ajax({
            url: actionUrl,
            method: 'POST',
            data: form.serialize(),
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function(response) {
                $('#modalForm').find('.close').trigger('click');
                Swal.fire({
                    icon: 'success',
                    title: successMessage || `${response.message}`,
                    confirmButtonText: 'Oke',
                    confirmButtonColor: '#5e72e4'
                }).then((result) => {
                    if (result.isConfirmed) {
                      location.reload();
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
        })
    });
}

function submitFormUploadAjaxModal(formSelector, actionUrl, successMessage) {
    $(formSelector).on('submit', function(e) {
        e.preventDefault();
        let form = $(this);
        let formData = new FormData(form[0]);
        $.ajax({
            url: actionUrl,
            method: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            contentType: false, // Jangan set content-type secara manual, biarkan FormData yang mengaturnya
            processData: false, // Jangan proses data (karena kita mengirimkan FormData)
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: successMessage || `${response.message}`,
                    confirmButtonText: 'Oke',
                    confirmButtonColor: '#5e72e4'
                }).then((result) => {
                    if (result.isConfirmed) {
                      location.reload();
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
        })
    });
}

function deleteDataAjax(url, table) {
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
                url: url,
                method: 'DELETE',
                success: function(response) {
                    Swal.fire('Berhasil', response.message, 'success');
                    table.ajax.reload();
                },
                error: function(xhr) {
                    Swal.fire('Gagal', xhr.responseJSON?.message || 'Terjadi kesalahan.', 'error');
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

function logoutUser() {
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Anda akan keluar dari aplikasi!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, keluar!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            $.ajax({
                url: route('logout'),
                method: 'POST',
                success: function(response) {
                    window.location.href = "/";
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

function initializeDataTable(tableSelector, ajaxRoute, columnsConfig) {
  var table = $(tableSelector).DataTable({
    destroy: true,
    responsive: true,
    processing: true,
    serverSide: true,
    ajax: ajaxRoute,
    columns: columnsConfig,
    language: {
      url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json', // CDN Bahasa Indonesia
    }
  });

  // Custom pagination icons
  table.on('draw', function() {
    $('#DataTables_Table_0_previous a').html('<i class="ni ni-bold-left"></i>');
    $('#DataTables_Table_0_next a').html('<i class="ni ni-bold-right"></i>');
  });

  return table;
}

function updateStatusAjax(url, table, status) {
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Status data akan diubah menjadi "+status+"!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Saya Yakin!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            $.ajax({
                url: url,
                method: 'POST',
                success: function(response) {
                    Swal.fire('Berhasil', response.message, 'success');
                    table.ajax.reload();
                },
                error: function(xhr) {
                    Swal.fire('Gagal', xhr.responseJSON?.message || 'Terjadi kesalahan.', 'error');
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


 function capitalizeWords(input) {
      let words = input.value.split(' ');
      for (let i = 0; i < words.length; i++) {
        words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1).toLowerCase();
      }
      input.value = words.join(' ');
    }

 function uppercaseWords(input) {
      input.value = input.value.toUpperCase();
    }

function convertHisToHi(timeString) {
  const parts = timeString.split(':');
  // Ensure there are at least two parts (hour and minute)
  if (parts.length >= 2) {
    return `${parts[0]}:${parts[1]}`;
  } else {
    // Handle cases where the input string is not in the expected format
    return null; // Or throw an error, depending on your error handling strategy
  }
}