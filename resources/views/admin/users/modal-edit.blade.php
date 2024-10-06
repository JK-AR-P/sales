<div class="modal fade" id="editModalMarketing" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <form action="" class="xform" method="POST" id="formEditUser" class="xform">
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Edit Data Marketing</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Nama</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" class="form-control" name="fullname" placeholder="Fullname" value="Rifan Hardiyan">
                        </div>

                        <div class="col-md-4">
                            <label>Username</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" class="form-control" name="username" placeholder="Username" value="Rifan Hardiyan">
                        </div>

                        <div class="col-md-4">
                            <label>Email</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="email" class="form-control" name="email" placeholder="Email" value="rifan@arita.co.id">
                        </div>

                        <div class="col-md-4">
                            <label>Telepon</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" class="form-control" name="telp" placeholder="0" value="081345946704">
                        </div>

                        <div class="col-md-4">
                            <label>Tgl Lahir</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="date" class="form-control" name="birthdate">
                        </div>

                        <div class="col-md-4">
                            <label>Wilayah</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" class="form-control" name="region" placeholder="Wilayah" value="Jakarta">
                        </div>

                        {{-- <div class="col-md-4">
                            <label>Upload Foto</label>
                        </div>
                        <div class="col-md-8">
                            <div class="form-file">
                                <input type="file" class="form-file-input" id="customFile">
                                <label class="form-file-label" for="customFile">
                                    <span class="form-file-text">Choose file...</span>
                                    <span class="form-file-button">Browse</span>
                                </label>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="submit" class="btn btn-primary ml-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Submit</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
