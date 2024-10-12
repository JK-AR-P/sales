@extends('layouts.admin_main')
@section('css')
    <style>
        .dz-preview.dz-file-preview {
            border: 1px solid #e0e0e0;
            padding: 8px;
            margin-bottom: 8px;
            background-color: #f9f9f9;
            border-radius: 4px;
            overflow: hidden;
        }

        .dropzone .dz-preview {
            margin: 0 !important;
        }

        .dz-details {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .dz-icon {
            width: 40px; /* Ukuran icon */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .dz-size {
            font-size: 10px;
            color: #888;
        }

        .dz-delete {
            font-size: 10px;
            background-color: transparent;
            color: #dc3545;
        }

        .dz-filename {
            max-width: 120px; /* Adjust this for wider names */
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .dz-filename span {
            font-size: 14px;
            color: #333;
        }
    </style>
@endsection
@section('content')
    <div class="main-content container-fluid">

    <div class="page-title">
        <div class="row mb-2">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h4>List File Company Profile</h4>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class='breadcrumb-header'>
                    <ol class="breadcrumb">
                        <button class="btn icon icon-left btn-primary" id="btnAddCompanyProfile"><i data-feather="plus"></i> Add Data</button>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class='table table-striped' id="tableCompanyProfile">
                        <thead>
                            <tr>
                                <th class="text-center" width="1%">No</th>
                                <th class="text-center" width="40%">Nama Perusahaan</th>
                                <th class="text-center">File .PDF / .PPT</th>
                                <th class="text-center" width="20%"><i class="fa fa-gear"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <td colspan="4" class="text-center">
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

    @include('admin.company.modal-add')
    @include('admin.company.modal-preview')

</div>
@endsection
@section('js')
<script>
    $(document).ready(function() {
        let tableCompanyProfile;
        $(function() {
            loadData();

            Dropzone.autoDiscover = false;
            /**
             * Setup dropzone
             */

            let myDropzone = new Dropzone("#formAddCompanyProfile", {
                previewTemplate: $('#dzPreviewContainer').html(),
                url: '{{ route('admin.company.store') }}',
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 5,
                maxFiles: 5,
                maxFilesize: 2, // Limit of 2 MB
                acceptedFiles: '.pdf, .ppt, .pptx', // Only accept these file types
                previewsContainer: "#previews",
                timeout: 0,
                init: function() {
                    var myDropzone = this;

                    // Event for adding a file
                    this.on('addedfile', function(file) {

                        // Always reset invalid status on adding a new file
                        $('.dropzone-drag-area').removeClass('is-invalid');
                        $('.invalid-feedback').html('').hide();
                        $('#formSubmit').prop('disabled', false);
                        $('[data-dz-message]').html('To remove click the red button');

                        // Get the file extension
                        var fileType = file.name.split('.').pop().toLowerCase();
                        var iconClass = 'fa-file';

                        if (['pdf'].includes(fileType)) {
                            iconClass = 'fa-file-pdf'; // PDF icon
                        } else if (['ppt', 'pptx'].includes(fileType)) {
                            iconClass = 'fa-file-powerpoint'; // PowerPoint icon
                        }

                        // Update the icon in the preview
                        $(file.previewElement).find('.dz-icon i').attr('class', 'fa ' + iconClass + ' fa-3x');

                        // Display file size in KB
                        var fileSizeKB = file.size / 1024;
                        var displaySize = fileSizeKB < 1 ? fileSizeKB.toFixed(2) : Math.round(fileSizeKB);
                        $(file.previewElement).find('.dz-size').text(displaySize + ' KB');
                    });

                    // Event for success (when the file is accepted)
                    this.on('success', function(file) {
                        console.log("File accepted: ", file);
                        $('.dropzone-drag-area').removeClass('is-invalid');
                        $('.invalid-feedback').html('').hide();
                    });

                    // Event for error (when the file is rejected)
                    this.on('error', function(file, message) {
                        console.log("File rejected: ", file);
                        $('.dropzone-drag-area').addClass('is-invalid');
                        $('.invalid-feedback').html(message).show();
                        this.removeFile(file);
                    });

                    // Accept callback for custom validation
                    this.on('accept', function(file, done) {
                        if (['pdf', 'ppt', 'pptx'].includes(file.name.split('.').pop().toLowerCase())) {
                            done(); // Accept the file
                        } else {
                            done("Invalid file type. Only .pdf, .ppt, and .pptx are allowed."); // Reject the file
                        }
                    });
                }
            });


            $('#formSubmit').on('click', function(event) {
                let form = $('#formAddCompanyProfile');
                event.preventDefault();
                var $this = $(this);

                // Show submit button spinner
                $this.children('.spinner-border').removeClass('d-none');

                // Validate form & submit if valid
                if (form[0].checkValidity() === false) {
                    event.stopPropagation();

                    form.addClass('was-validated');

                    if (!myDropzone.getQueuedFiles().length > 0) {
                        $('.dropzone-drag-area').addClass('is-invalid').next('.invalid-feedback').show();
                    }
                } else {
                    // Append Dropzone files to FormData
                    var formData = new FormData(form[0]);
                    myDropzone.files.forEach(function(file) {
                        formData.append('files[]', file);
                    });

                    // Use AJAX for form submission
                    $.ajax({
                        url: form.attr('action')
                        , type: 'POST'
                        , data: formData
                        , processData: false
                        , contentType: false
                        , beforeSend: function() {
                            Swal.fire({
                                title: 'On progress...'
                                , html: 'Please wait...'
                                , allowEscapeKey: false
                                , allowOutsideClick: false
                                , didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                        }
                        , success: function(res) {
                            Pace.stop();
                            Swal.close();

                            let fields = [
                                form.find('input')
                                , form.find('select')
                                , form.find('textarea')
                            ];

                            for (let i in fields) {
                                fields[i].removeClass('is-invalid');
                                fields[i].parent().find('span.invalid-feedback').remove();
                            }

                            if (res.status === 'success') {
                                form.trigger('xform-success', [res]);
                            } else if (res.status === 'error') {
                                $('.card-login').removeClass('animate__zoomInUp').addClass('animate__jello');
                                form.trigger('xform-error', [res]);
                            }

                            if (res.resets) {
                                if ('all' === res.resets) {
                                    form.trigger('reset');
                                    form.find('label.custom-file-label').html('Choose file');
                                } else {
                                    for (let i in res.resets) {
                                        let name = res.resets[i];
                                        form.find('input[name="' + name + '"]').val('');
                                        form.find('select[name="' + name + '"]').val('');
                                        form.find('textarea[name="' + name + '"]').html('');
                                        form.find('label.custom-file-label').html('');
                                    }
                                }
                            }

                            if (res.errors) {
                                let focus_first_error_field = true;
                                for (let field in res.errors) {
                                    let message = res.errors[field][0];
                                    let input = form.find(`input[name="${field}"]`);

                                        if (input.length > 0) {
                                            input.addClass("is-invalid");
                                            input.parent().append(`<span class="invalid-feedback">${message}</span>`);
                                            if (focus_first_error_field) {
                                                input.focus();
                                                focus_first_error_field = false;
                                            }
                                        }

                                        // Process select fields
                                        let select = form.find(`select[name="${field}"]`);
                                        if (select.length > 0) {
                                            select.addClass("is-invalid");
                                            select.parent().append(`<span class="invalid-feedback">${message}</span>`);
                                            if (focus_first_error_field) {
                                                select.focus();
                                                focus_first_error_field = false;
                                            }
                                        }

                                        // Process textarea fields
                                        let textarea = form.find(`textarea[name="${field}"]`);
                                        if (textarea.length > 0) {
                                            textarea.addClass("is-invalid");
                                            textarea.parent().append(`<span class="invalid-feedback">${message}</span>`);
                                            if (focus_first_error_field) {
                                                textarea.focus();
                                                focus_first_error_field = false;
                                            }
                                        }
                                }
                            }

                            if (res.toast) {
                                if ('success' == res.status) {
                                    toastr.success(res.toast);
                                } else if ('info' == res.status) {
                                    toastr.info(res.toast);
                                } else if ('error' == res.status) {
                                    toastr.error(res.toast);
                                } else if ('warning' == res.status) {
                                    toastr.warning(res.toast);
                                }
                            }

                            if (res.redirect) {
                                setTimeout(function() {
                                    toastr.info('Redirecting...');
                                }, 1000);
                                setTimeout(function() {
                                    window.location.href = res.redirect;
                                }, 2000);
                            }

                            // Hide submit button spinner
                            $this.children('.spinner-border').addClass('d-none');
                        }
                        , error: function(err) {
                            Pace.stop();
                            Swal.close();
                            form.find('.submit').prop('disabled', false);

                            if (err.responseJSON) {
                                toastr.error(err.statusText + ' | ' + err.responseJSON.message);
                            } else {
                                toastr.error(err.statusText);
                            }
                        }
                    });
                }
            });

            $('#btnAddCompanyProfile').on('click', function() {
                add()
            })
        })

        loadData = function() {
            if (undefined !== tableCompanyProfile) {
                tableCompanyProfile.destroy()
                tableCompanyProfile.clear().draw();
            }

            tableCompanyProfile = $('#tableCompanyProfile').DataTable({
                responsive: true
                , searching: true
                , autoWidth: false
                , processing: true
                , serverSide: true
                , aLengthMenu: [
                    [5, 10, 25, 50, 100, 250, 500, -1]
                    , [5, 10, 25, 50, 100, 250, 500, "All"]
                ]
                , pageLength: 25
                , ajax: "{{ route('admin.company.data') }}"
                , drawCallback: function(settings) {
                    $('table#tableCompanyProfile tr').on('click', '#preview', function(e) {
                        e.preventDefault();

                        let files = $(this).data('files')
                        let name = $(this).data('name')

                        let data = {
                            name: name,
                            files: files
                        };

                        preview(data)
                    })

                    $('table#tableCompanyProfile tr').on('click', '#hapus', function(e) {
                        e.preventDefault();

                        let data = tableCompanyProfile.row($(this).parents('tr')).data();
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
                        data: 'name'
                        , name: 'name'
                    }
                    , {
                        data: 'files'
                        , name: 'files'
                        , class: 'fixed-side text-center'
                        , orderable: false
                        , searchable: false
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
            tableCompanyProfile.on('draw', function() {
                $('[data-toggle="tooltip"]').tooltip()
            })
        }

        add = function() {
            let form = $('#formAddCompanyProfile')
            TriggerReset(form)

            $('div#addCompanyProfile').on('show.bs.modal', function() {
                $('div#addCompanyProfile').off('hidden.bs.modal')
                if ($('body').hasClass('modal-open')) {
                    $('div#addCompanyProfile').on('hidden.bs.modal', function() {
                        $('body').addClass('modal-open')
                    })
                }
            }).modal('show')

            form.off('xform-success').on('xform-success', function() {
                tableCompanyProfile.ajax.reload(null, false)
                $('div#addCompanyProfile').modal('hide')
            })
        }

        preview = function(data) {
            console.log(data);
            
            let files = data.files;
            
            $('table.modal-table-files tbody').empty();
            $('#titleModalPreview').text('File ' + data.name);

            files.forEach(function(file) {
                let fileSize = (file.file_size / 1024).toFixed(2) + ' KB';

                let trimmedFileName = file.file_name;
                if (trimmedFileName.length > 20) {
                    trimmedFileName = trimmedFileName.substring(0, 20) + '...';
                }

                let fileRow = `
                    <tr>
                        <td>${trimmedFileName}</td>
                        <td class="text-center">${file.file_type.toUpperCase()}</td>
                        <td class="text-center">${fileSize}</td>
                        <td class="text-center">
                            <a href="/storage/${file.file_path}" target="_blank">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                `;
                // Append the new row to the table body
                $('table.modal-table-files tbody').append(fileRow);
            });

            // Show the modal
            $('div#previewFile').on('show.bs.modal', function() {
                $('div#previewFile').off('hidden.bs.modal');
                if ($('body').hasClass('modal-open')) {
                    $('div#previewFile').on('hidden.bs.modal', function() {
                        $('body').addClass('modal-open');
                    });
                }
            }).modal('show');
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

                            tableCompanyProfile.ajax.reload(null, false)
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
    })
</script>
@endsection
