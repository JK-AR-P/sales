<div class="modal fade" id="addMarketing" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.marketing.store') }}" class="xform" method="POST" id="formAddUser">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Add Data Marketing</h5>
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
                            <input type="text" class="form-control" name="fullname" placeholder="Nama" required>
                        </div>

                        <div class="col-md-4">
                            <label>Email</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                        </div>

                        <div class="col-md-4">
                            <label>Telepon</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="number" class="form-control" name="telp" placeholder="0" required>
                        </div>

                        <div class="col-md-4">
                            <label>Tgl Lahir</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="date" class="form-control" name="birthdate" required>
                        </div>

                        <div class="col-md-4">
                            <label>Wilayah</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" class="form-control" name="region" placeholder="Wilayah" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="submit" class="btn btn-primary ml-1" data-bs-dismiss="modal">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Submit</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
