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
        return view('admin.users.index');
    }

    public function data(Request $request): JsonResponse
    {
        $users = User::role('user')->select('id', 'fullname', 'email', 'username', 'telp', 'birthdate', 'region', 'photo_profile')->get();
        if ($request->ajax()) {
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('birthdate', function ($row) {
                    return $row['birthdate'] ? Carbon::parse($row['birthdate'])->format('d-m-Y') : '';
                })
                ->addColumn('photo_profile', function ($row) {
                    if (empty($row['photo_profile'])) {
                        return '<img src="' . Avatar::generateAvatar($row['fullname']) . '" class="rounded-circle w-10 h-10" alt="Profile">';
                    }

                    return '<img src="' . $row['photo_profile'] . '" class="rounded-circle w-10 h-10" alt="Profile">';
                })
                ->addColumn('action', function ($row) {
                    $route_update = route('admin.marketing.update', encrypt($row['id']));
                    $route_delete = route('admin.marketing.destroy', encrypt($row['id']));
                    $btn = '';

                    $btn .= '<a href="javascript:void(0)" class="btn btn-sm icon btn-warning text-white me-2" id="ubah" title="Edit" data-toggle="tooltip" data-placement="top" data-url="' . $route_update . '"><i class="fa fa-edit"></i></a>';
                    $btn .= '<a href="javascript:void(0)" class="btn btn-sm icon btn-danger text-white" id="hapus" title="Delete" data-toggle="tooltip" data-placement="top" data-url="' . $route_delete . '"><i class="fa fa-trash"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action', 'photo_profile'])
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

            $user = User::create([
                'fullname' => $request->fullname,
                'email' => $request->email,
                'telp' => $request->telp,
                'birthdate' => $request->birthdate,
                'region' => $request->region,
                'photo_profile' => null,
                'password' => Hash::make('password'),
            ]);

            $user->assignRole('user');

            DB::commit();

            return response()->json([
                'status' => 'success',
                'toast' => 'New user added successfully'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'toast' => 'Error while adding new user' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
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
                'fullname' => $request->fullname,
                'email' => $request->email,
                'telp' => $request->telp,
                'birthdate' => $request->birthdate,
                'region' => $request->region,
                'photo_profile' => null,
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
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'toast' => 'Error while deleting user' . $e->getMessage(),
            ], 500);
        }
    }
}
