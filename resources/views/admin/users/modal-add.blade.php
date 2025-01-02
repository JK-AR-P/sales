<div class="modal fade" id="addMarketing" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable modal-lg" role="document" data-backdrop="static">
        <div class="modal-content">
            <form action="{{ route('admin.users.store') }}" class="xform" method="POST" id="formAddUser">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Add Admin User</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Perusahaan</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <select name="id_company" id="id_company" class="form-control" aria-label="Company">
                                <option value="0" selected disabled>Pilih Perusahaan</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->kd_company }} - {{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label>Username</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
                        </div>

                        <div class="col-md-4">
                            <label>Password</label>
                        </div>
                        <div class="col-md-8 form-group password-field">
                            <input type="password" class="form-control" name="password" id="password" placeholder="*****" required>
                            <i class="far fa-eye toggle-password" id="togglePassword"></i>
                        </div>
                        <div class="col-md-4">
                            <label>Confirm Password</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="password" class="form-control" name="password_confirmation" placeholder="*****" required>
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
                        <span class="d-none d-sm-block">Submit</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
