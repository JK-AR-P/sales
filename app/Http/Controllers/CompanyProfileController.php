<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CompanyProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        return view('admin.company.index');
    }

    public function data(Request $request) : JsonResponse
    {
        $companies = CompanyProfile::select('id', 'name', 'file')->get();
        if ($request->ajax()) {
            return DataTables::of($companies)
                ->addIndexColumn()
                ->addColumn('file', function ($row) {
                    return '<button class="btn icon btn-info"><i data-feather="file-text"></i></button>';
                })
                ->addColumn('action', function ($row) {
                    $route_update = route('admin.company.update', encrypt($row['id']));
                    $route_delete = route('admin.company.destroy', encrypt($row['id']));
                    $btn = '';

                    $btn .= '<a href="javascript:void(0)" class="btn btn-sm icon btn-warning text-white me-2" id="ubah" title="Edit" data-toggle="tooltip" data-placement="top" data-url="' . $route_update . '"><i class="fa fa-edit"></i></a>';
                    $btn .= '<a href="javascript:void(0)" class="btn btn-sm icon btn-danger text-white" id="hapus" title="Delete" data-toggle="tooltip" data-placement="top" data-url="' . $route_delete . '"><i class="fa fa-trash"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action', 'file'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CompanyProfile $companyProfile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CompanyProfile $companyProfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CompanyProfile $companyProfile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CompanyProfile $companyProfile)
    {
        //
    }
}
