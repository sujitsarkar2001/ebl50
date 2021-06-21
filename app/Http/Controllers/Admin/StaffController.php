<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $staffs = User::where('is_admin', true)->latest('id')->get();
        return view('admin.staff.index', compact('staffs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.staff.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "name"      => "required|string|max:50",
            "username"  => "required|string|max:50|unique:users,username",
            "email"     => "required|string|max:50",
            "phone"     => "required|string|max:30",
            "password"  => "required|string|min:8|confirmed"
        ]);

        User::create([
            'sponsor_id'        => 0,
            'placement_id'      => 0,
            'direction'         => 0,
            'name'              => $request->name,
            'username'          => $request->username,
            'email'             => $request->email,
            'phone'             => $request->phone,
            'is_admin'          => true,
            'is_approved'       => true,
            'joining_date'      => date('Y-m-d'),
            'joining_month'     => date('F'),
            'joining_year'      => date('Y'),
            'email_verified_at' => now(),
            'password'          => Hash::make($request->password),
            'remember_token'    => Str::random(10)
        ]);

        return response()->json([
            'alert'   => 'Success',
            'message' => 'Staff successfully added'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $staff = User::where('id', $id)->where('is_admin', true)->firstOrFail(['id', 'name', 'username', 'email', 'phone']);
        return response()->json($staff);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $staff = User::where('id', $id)->where('is_admin', true)->firstOrFail();
        return view('admin.staff.form', compact('staff'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $staff = User::where('id', $id)->where('is_admin', true)->firstOrFail();
        $this->validate($request, [
            "name"      => "required|string|max:50",
            "username"  => "required|string|max:50|unique:users,username,".$id,
            "email"     => "required|string|max:50",
            "phone"     => "required|string|max:30"
        ]);

        $staff->update([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'phone'    => $request->phone
        ]);

        return response()->json([
            'alert'   => 'Success',
            'message' => 'Staff successfully updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $staff = User::where('id', $id)->where('is_admin', true)->firstOrFail();
        if (file_exists('uploads/member/'.$staff->avatar)) {
            unlink('uploads/member/'.$staff->avatar);
        }
        $staff->delete();
        return response()->json([
            'alert'   => 'Success',
            'message' => 'Staff successfully deleted'
        ]);
    }
}
