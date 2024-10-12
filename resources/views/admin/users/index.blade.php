@extends('layouts.admin_main')
@section('content')
<div class="main-content container-fluid">

    <div class="page-title">
        <div class="row mb-2">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h4>List User Marketing</h4>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class='breadcrumb-header'>
                    <ol class="breadcrumb">
                        <button href="#" class="btn icon icon-left btn-primary" id="btnAddUser"><i data-feather="plus"></i> Add Data</button>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class='table table-striped table-sm' id="tableUsers">
                        <thead class="thead-dark text-center text-light">
                            <tr>
                                <th class="text-center" width="1%">No</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center" width="8%">Email</th>
                                <th class="text-center" width="10%">Telepon</th>
                                <th class="text-center">Tgl Lahir</th>
                                <th class="text-center" width="8%">Wilayah</th>
                                <th class="text-center">Foto</th>
                                <th class="text-center" width="10%"><i class="fa fa-gear"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <td colspan="8" class="text-center">
                                <div class="d-flex justify-content-center">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    @include('admin.users.modal-add')
    @include('admin.users.modal-edit')

</div>
@endsection
@section('js')
<script>
    $(document).ready(function() {
        let tableUsers;
            $(function() {
                loadData();

                $('#btnAddUser').on('click', function() {
                    add()
                })
            });

            loadData = function() {
                if (undefined !== tableUsers) {
                    tableUsers.destroy()
                    tableUsers.clear().draw();
                }

                tableUsers = $('#tableUsers').DataTable({
                    responsive: true
                    , searching: true
                    , autoWidth: false
                    , processing: true
                    , serverSide: true
                    , aLengthMenu: [
                        [5, 10, 25, 50, 100, 250, 500, -1]
                        , [5, 10, 25, 50, 100, 250, 500, "All"]
                    ]
                    , pageLength: 50
                    , ajax: "{{ route('admin.marketing.data') }}"
                    , drawCallback: function(settings) {
                        $('table#tableUsers tr').on('click', '#ubah', function(e) {
                            e.preventDefault();

                            let data = tableUsers.row($(this).parents('tr')).data();
                            let url = $(this).data('url')
                            edit(data, url)
                        })

                        $('table#tableUsers tr').on('click', '#hapus', function(e) {
                            e.preventDefault();

                            let data = tableUsers.row($(this).parents('tr')).data();
                            let url = $(this).data('url')
                            destroy(data, url)
                        })
                    }
                    , columns: [{
                            data: 'DT_RowIndex'
                            , name: 'DT_RowIndex'
                            , width: '1%'
                            , class: 'fixed-side text-center'
                        }
                        , {
                            data: 'fullname'
                            , name: 'fullname'
                        }
                        , {
                            data: 'email'
                            , name: 'email'
                        }
                        , {
                            data: 'telp'
                            , name: 'telp'
                        }
                        , {
                            data: 'birthdate'
                            , name: 'birthdate'
                        }
                        , {
                            data: 'region'
                            , name: 'region'
                        }
                        , {
                            data: 'photo_profile'
                            , name: 'photo_profile'
                            , class: 'fixed-side text-center'
                        }
                        , {
                            data: 'action'
                            , name: 'action'
                            , class: 'fixed-side text-center'
                            , orderable: false
                            , searchable: false
                        }
                    , ]
                , })
                tableUsers.on('draw', function() {
                    $('[data-toggle="tooltip"]').tooltip()
                })
            }

            add = function() {
                let form = $('#formAddUser')
                TriggerReset(form)

                $('div#addMarketing').on('show.bs.modal', function() {
                    $('div#addMarketing').off('hidden.bs.modal')
                    if ($('body').hasClass('modal-open')) {
                        $('div#addMarketing').on('hidden.bs.modal', function() {
                            $('body').addClass('modal-open')
                        })
                    }
                }).modal('show')

                form.off('xform-success').on('xform-success', function() {
                    tableUsers.ajax.reload(null, false)
                    $('div#addMarketing').modal('hide')
                })
            }

            edit = function(data, url) {
                let form = $('#formEditUser')
                TriggerReset(form)
                form.attr('action', url)

                form.find('input, select').each(function() {
                    let inputName = $(this).attr('name');
                    if (data[inputName]) {
                        if (inputName === 'birthdate') {
                            $(this).val(moment(data[inputName], 'YYYY-MM-DD').format('YYYY-MM-DD')); // Format sesuai input date
                        } else {
                            $(this).val(data[inputName]); // Set value if key exists in data
                        }
                    }
                });

                $('div#editModalMarketing').on('show.bs.modal', function() {
                    $('div#editModalMarketing').off('hidden.bs.modal')
                    if ($('body').hasClass('modal-open')) {
                        $('div#editModalMarketing').on('hidden.bs.modal', function() {
                            $('body').addClass('modal-open')
                        })
                    }
                }).modal('show')

                form.off('xform-success').on('xform-success', function() {
                    tableUsers.ajax.reload(null, false)
                    $('div#editModalMarketing').modal('hide')
                })
            }

            destroy = function(data, url) {
                Swal.fire({
                    title: 'Are you sure?'
                    , text: "Want to delete this data?"
                    , icon: 'warning'
                    , showCancelButton: true
                    , confirmButtonColor: '#6777EF'
                    , cancelButtonColor: '#FC544B'
                    , confirmButtonText: 'Yes!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url
                            , data: {
                                _token: "{{ csrf_token() }}"
                                , _method: "delete"
                            }
                            , type: 'POST'
                            , success: function(res) {
                                if (res.status == 'success') {
                                    toastr.success(res.toast)
                                } else if (res.status == 'error') {
                                    toastr.error(res.toast)
                                }

                                tableUsers.ajax.reload(null, false)
                            }
                            , error: function(err) {
                                if (err.responseJSON) {
                                    toastr.error(err.statusText + ' | ' + err.responseJSON.message)
                                } else {
                                    toastr.error(err.statusText)
                                }
                            }
                        })
                    }
                })
            }

    });

</script>
@endsection
