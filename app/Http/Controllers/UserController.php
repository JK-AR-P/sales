<?php

namespace App\Http\Controllers;

use App\Helper\Avatar;
use App\Http\Requests\User\NewUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $companies = DB::table('hris.companies')->select('id', 'name', 'kd_company')->get();

        return view('admin.users.index', compact('companies'));
    }

    public function data(Request $request): JsonResponse
    {
        $users = DB::table('e_catalog.users as u')
        ->leftJoin('hris.companies as c', 'u.id_company', '=', 'c.id')
        ->select('u.id', 'u.username', 'c.name as company_name', 'c.kd_company', 'u.id_company')
        ->get();

        if ($request->ajax()) {
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('username', function ($row) {
                    return $row->username;
                })
                ->addColumn('company', function ($row) {
                    return $row->company_name ? $row->kd_company . ' / ' .$row->company_name : '-'; // Handle null values
                })
                ->addColumn('action', function ($row) {
                    $route_update = route('admin.users.update', encrypt($row->id));
                    $route_delete = route('admin.users.destroy', encrypt($row->id));
                    
                    $btn = '';
                    $btn .= '<a href="javascript:void(0)" class="btn btn-sm icon btn-warning text-white me-2" id="ubah" title="Edit" data-toggle="tooltip" data-placement="top" data-url="' . $route_update . '" data-company="' . $row->id_company . '"><i class="fa fa-edit"></i></a>';
                    $btn .= '<a href="javascript:void(0)" class="btn btn-sm icon btn-danger text-white" id="hapus" title="Delete" data-toggle="tooltip" data-placement="top" data-url="' . $route_delete . '"><i class="fa fa-trash"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
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
    public function store(NewUserRequest $request)
    {
        try {
            DB::beginTransaction();

            $admin = User::create([
                'id_company' => $request->id_company,
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);

            $admin->assignRole('admin');

            DB::commit();

            return response()->json([
                'status' => 'success',
                'toast' => 'New admin added successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'toast' => 'Error while adding new admin' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find(decrypt($id));


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::find(decrypt($id));
        try {
            DB::beginTransaction();

            $user->update([
                'id_company' => $request->id_company,
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'toast' => 'User updated successfully'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'toast' => 'Error while updating user' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find(decrypt($id));
        try {
            DB::beginTransaction();

            $user->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'toast' => 'User deleted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'toast' => 'Error while deleting user' . $e->getMessage(),
            ]);
        }
    }
}
