<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\CompanyProfile;
use Illuminate\Http\JsonResponse;
use App\Models\CompanyProfileFile;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Catalog\NewCatalogRequest;
use App\Models\CatalogFiles;
use Exception;
use Illuminate\Support\Facades\Storage;

class CatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.catalog.index');
    }

    public function data(Request $request): JsonResponse
    {
        $catalogs = Catalog::select('id', 'name')->with('catalog_files')->get();
        if ($request->ajax()) {
            return DataTables::of($catalogs)
                ->addIndexColumn()
                ->addColumn('files', function ($row) {
                    $btn = '<button class="btn icon btn-info" id="preview" data-name="' . $row->name . '" data-files=\'' . json_encode($row->catalog_files) . '\'><i class="fa fa-file"></i></button>';
                    return $btn;
                })
                ->addColumn('action', function ($row) {
                    $route_delete = route('admin.catalog.destroy', encrypt($row['id']));
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
    public function store(NewCatalogRequest $request)
    {
        try {
            DB::beginTransaction();

            $catalog = new Catalog();
            $catalog->name = $request->name;
            $catalog->save();

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    // Generate a unique filename
                    $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension();
                    $finalName = $filename . '-' . now()->format('d_m_Y') . '.' . $extension;

                    $path = $file->storeAs('catalog', $finalName, 'public');
                    $fileSize = $file->getSize();

                    $file = new CatalogFiles();
                    $file->catalog_id = $catalog->id;
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
                'toast' => 'Catalog file added successfully',
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'toast' => 'Error while adding new catalog file ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Catalog $catalog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Catalog $catalog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Catalog $catalog)
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
            $catalog = Catalog::find(decrypt($id));

            if (!$catalog) {
                return response()->json([
                    'status' => 'error',
                    'toast' => 'Company profile not found.',
                ]);
            }

            $files = $catalog->catalog_files;

            foreach ($files as $file) {
                Storage::disk('public')->delete($file->file_path);
                $file->delete();
            }

            $catalog->delete();

            DB::commit();
            return response()->json([
                'status' => 'success',
                'toast' => 'Catalog file deleted successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'toast' => 'Error while deleting catalog files: ' . $e->getMessage(),
            ]);
        }
    }
}
