<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\NewCompanyProfileRequest;
use App\Models\CompanyProfile;
use App\Models\CompanyProfileFile;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class CompanyProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.company.index');
    }

    public function data(Request $request): JsonResponse
    {
        $companies = CompanyProfile::select('id', 'name')->with('company_profile_files')->get();
        if ($request->ajax()) {
            return DataTables::of($companies)
                ->addIndexColumn()
                ->addColumn('files', function ($row) {
                    $btn = '<button class="btn icon btn-info" id="preview" data-name="' . $row->name . '" data-files=\'' . json_encode($row->company_profile_files) . '\'><i class="fa fa-file"></i></button>';
                    return $btn;
                })
                ->addColumn('action', function ($row) {
                    $route_delete = route('admin.company.destroy', encrypt($row['id']));
                    $btn = '';

                    $btn .= '<a href="javascript:void(0)" class="btn btn-sm icon btn-danger text-white" id="hapus" title="Delete" data-toggle="tooltip" data-placement="top" data-url="' . $route_delete . '"><i class="fa fa-trash"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action', 'files'])
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
    public function store(NewCompanyProfileRequest $request)
    {
        try {
            DB::beginTransaction();

            $companyProfile = new CompanyProfile();
            $companyProfile->id_company = $request->id_company;
            $companyProfile->save();

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    // Generate a unique filename
                    $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension();
                    $finalName = $filename . '-' . now()->format('d_m_Y') . '.' . $extension;

                    $path = $file->storeAs('company_profile', $finalName, 'public');
                    $fileSize = $file->getSize();

                    $file = new CompanyProfileFile();
                    $file->company_profile_id = $companyProfile->id;
                    $file->file_name = $finalName;
                    $file->file_path = $path;
                    $file->file_type = $extension;
                    $file->file_size = $fileSize;
                    $file->save();
                }
            }

            DB::commit();
            return response()->json([
                'status' => 'success',
                'toast' => 'Company profile added successfully',
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'toast' => 'Error while adding new company profile ' . $e->getMessage(),
            ]);
        }
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
    public function edit(Request $request, $id)
    {

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
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $companyProfile = CompanyProfile::find(decrypt($id));

            if (!$companyProfile) {
                return response()->json([
                    'status' => 'error',
                    'toast' => 'Company profile not found.',
                ]);
            }

            $files = $companyProfile->company_profile_files;

            foreach ($files as $file) {
                Storage::disk('public')->delete($file->file_path);
                $file->delete();
            }

            $companyProfile->delete();

            DB::commit();
            return response()->json([
                'status' => 'success',
                'toast' => 'Company profile deleted successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'toast' => 'Error while deleting company profile: ' . $e->getMessage(),
            ]);
        }
    }

    public function getCompanies()
    {
        $companies = DB::table('hris.companies')
                        ->select('id', 'name', 'kd_company')
                        ->orderBy('name', 'asc')
                        ->where('deleted_at', null)
                        ->get();

        return response()->json([
            'status' => 'success',
            'data' => $companies,
        ]);
    }
}
