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
                                <th class="text-center">Nama Perusahaan</th>
                                <th class="text-center">File .PDF / .PPT</th>
                                <th class="text-center" width="10%"><i class="fa fa-gear"></i></th>
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
             var myDropzone = new Dropzone("#formAddCompanyProfile", {
                previewTemplate: $('#dzPreviewContainer').html(),
                url: '{{ route('admin.company.store') }}',
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 5,
                maxFiles: 5,
                maxFilesize: 2, // Limit of 2 MB
                acceptedFiles: '.pdf, .ppt, .pptx',
                previewsContainer: "#previews",
                timeout: 0,
                init: function() {
                    var myDropzone = this;

                    this.on('addedfile', function(file) {
                        $('[data-dz-message]').html('To remove click the X button');
                        $('.dropzone-drag-area').removeClass('is-invalid').next('.invalid-feedback').hide();

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

                    this.on('removedfile', function(file) {
                        if (myDropzone.files.length === 0) {
                            $('[data-dz-message]').html('<i class="fa-solid fa-cloud-arrow-up"></i> Click or Drag file here to upload');
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
                , pageLength: -1
                , ajax: "{{ route('admin.company.data') }}"
                , drawCallback: function(settings) {
                    $('table#tableCompanyProfile tr').on('click', '#ubah', function(e) {
                        e.preventDefault();

                        let data = tableCompanyProfile.row($(this).parents('tr')).data();
                        let url = $(this).data('url')
                        edit(data, url)
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
                        data: 'file'
                        , name: 'file'
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
        }
    })
</script>
@endsection
