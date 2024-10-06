@extends('layouts.admin_main')
@section('content')
<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Dashboard</h3>
    </div>
    <section class="section">
        <div class="row mb-2">
            <div class="col-12 col-md-3" data-toggle="tooltip" data-placement="top" title="Request Certificate">
                <div class="card card-statistic">
                    <div class="card-body p-0">
                        <div class="d-flex flex-column">
                            <div class='px-3 py-3 d-flex justify-content-between'>
                                <h3 class='card-title'>{{ Str::limit('Request Certificate', 15, '...') }}</h3>
                                <div class="card-right d-flex align-items-center">
                                    <p>5 </p>
                                </div>
                            </div>
                            <div class="chart-wrapper text-center text-white">
                                <i data-feather="layers" width="40" style="height:100px"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3" data-toggle="tooltip" data-placement="top" title="Marketing">
                <div class="card card-statistic">
                    <div class="card-body p-0">
                        <div class="d-flex flex-column">
                            <div class='px-3 py-3 d-flex justify-content-between'>
                                <h3 class='card-title'>Marketing</h3>
                                <div class="card-right d-flex align-items-center">
                                    <p>30</p>
                                </div>
                            </div>
                            <div class="chart-wrapper text-center text-white">
                                <i data-feather="users" width="40" style="height:100px"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3" data-toggle="tooltip" data-placement="top" title="Company Profile">
                <div class="card card-statistic">
                    <div class="card-body p-0">
                        <div class="d-flex flex-column">
                            <div class='px-3 py-3 d-flex justify-content-between'>
                                <h3 class='card-title'>Company Profile</h3>
                                <div class="card-right d-flex align-items-center">
                                    <p>12</p>
                                </div>
                            </div>
                            <div class="chart-wrapper text-center text-white">
                                <i data-feather="globe" width="40" style="height:100px"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3" data-toggle="tooltip" data-placement="top" title="Catalog">
                <div class="card card-statistic">
                    <div class="card-body p-0">
                        <div class="d-flex flex-column">
                            <div class='px-3 py-3 d-flex justify-content-between'>
                                <h3 class='card-title'>Catalog</h3>
                                <div class="card-right d-flex align-items-center">
                                    <p>2</p>
                                </div>
                            </div>
                            <div class="chart-wrapper text-center text-white">
                                <i data-feather="book" width="40" style="height:100px"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
