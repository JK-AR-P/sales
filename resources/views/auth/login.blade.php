@extends('layouts.auth')
@section('content')
<div class="row">
    <div class="col-md-5 col-sm-12 mx-auto">
        <div class="card pt-4">
            <div class="card-body">
                <div class="text-center mb-5">
                    <img src="{{ asset('media/logo/logo_arita.png') }}" width="40%" class='mb-4'>
                    <h3>PT. ARITA PRIMA INDONESIA Tbk</h3>
                    <p>Please sign in to continue to Voler.</p>
                </div>
                <form action="{{ route('auth') }}" method="POST" class="xform">
                    <div class="form-group position-relative has-icon-left">
                        <label for="username">Username</label>
                        <div class="position-relative">
                            <input type="text" class="form-control" id="username" name="username">
                            <div class="form-control-icon">
                                <i data-feather="user"></i>
                            </div>
                        </div>
                    </div>
                    <div class="form-group position-relative has-icon-left">
                        <div class="clearfix">
                            <label for="password">Password</label>
                        </div>
                        <div class="position-relative">
                            <input type="password" class="form-control" id="password" name="password">
                            <div class="form-control-icon">
                                <i data-feather="lock"></i>
                            </div>
                        </div>
                    </div>
                    <div class="divider">
                        <div class="divider-text">Choose Role</div>
                    </div>
                    <div class="row justify-content-center mb-5">
                        <div class="col-12">
                            <select name="role" id="role" class="form-control" aria-label="Role">
                                <option value="admin">Admin</option>
                                <option value="user" selected>User</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-block mb-2 btn-primary"><i data-feather="log-in"></i>  LOGIN</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
