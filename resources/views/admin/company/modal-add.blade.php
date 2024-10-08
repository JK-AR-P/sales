<div class="modal fade" id="addCompanyProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.company.store') }}" method="POST" enctype="multipart/form-data" id="formAddCompanyProfile" class="xform dropzone">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Upload Company Profile</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Nama Perusahaan</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" class="form-control" name="name" placeholder="Nama">
                        </div>

                        <div class="col-md-4">
                            <label>Upload File .PDF / .PPT</label>
                        </div>
                        <div class="col-md-8">
                            <div class="form-file">
                                <div class="dropzone-drag-area form-control" id="previews">
                                    <div class="dz-message text-muted opacity-50 m-0" data-dz-message>
                                        <small><i class="fa-solid fa-cloud-arrow-up"></i> Click or Drag file here to upload</small>
                                    </div>
                                    <div class="d-none" id="dzPreviewContainer">
                                        <div class="dz-preview dz-file-preview d-flex align-items-center justify-content-between">
                                            <div class="dz-details d-flex align-items-center">
                                                <div class="dz-icon">
                                                    <i class="fa fa-file fa-3x"></i> <!-- Default icon, changed dynamically -->
                                                </div>
                                                <div class="row">
                                                    <div class="dz-filename ms-2"><span data-dz-name></span></div>
                                                    <div class="dz-size" data-dz-size></div>
                                                </div>
                                                <button class="dz-delete border-0 p-0 ms-2" type="button" data-dz-remove>
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="dz-error-message"><span data-dz-errormessage></span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="invalid-feedback fw-bold">Please upload an image.</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="submit" class="btn btn-primary ml-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Upload File</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
