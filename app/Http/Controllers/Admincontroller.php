<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Admincontroller extends Controller
{
    public function showInitializationForm()
    {
        // $admins = User::where('role', 'admin_room_911')->get();

        $admins = User::where('role', 'admin_room_911')
            ->get()
            ->map(function ($admin) {
                // Change true/false to active/inactive
                $admin->status = $admin->active ? 'active' : 'inactive';
                return $admin;
            });
        return view('admin.initialize', ['admins' => $admins]);
    }

    // Management admin only superuser
    public function initialize(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'status' => 'required| in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->route('initialize')
                ->withErrors($validator)
                ->withInput();
        }
        // Validated data
        $validatedData = $validator->validated();

        // Status to boolean
        $status = $validatedData['status'] === 'active' ? true : false;

        // Create a new admin
        User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin_room_911',
            'active' => $status
        ]);

        return redirect()->route('initialize')->with('success', 'Admi creado con éxito.');
    }

    public function editAdmin($id)
    {
        $admin = User::find($id);

        if ($admin) {
            $admin->status = $admin->active ? 'active' : 'inactive';
            return response()->json($admin);
        }

        return response()->json(['error' => 'Administrador no encontrado.'], 404);
    }

    public function updateAdmin(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $admin = User::find($id);

        if ($admin) {
            $admin->name = $request->name;
            $admin->last_name = $request->last_name;
            $admin->email = $request->email;

            if ($request->password) {
                $admin->password = Hash::make($request->password);
            }

            $admin->active = $request->status === 'active' ? true : false;
            $admin->save();

            return redirect()->route('initialize')->with('success', 'Administrador actualizado con éxito.');
        }

        return redirect()->route('initialize')->withErrors(['message' => 'Administrador no encontrado.']);
    }

    public function deleteAdmin($id)
    {
        $admin = User::where('id', $id)->where('role', 'admin_room_911')->first();

        if ($admin) {
            $admin->email = 'deleted_'.$admin->email;
            $admin->active= false;
            $admin->role = 'deleted_admin_room_911';
            $admin->save();
            return redirect()->back()->with('success', 'Administrador eliminado con éxito.');
        }

        return redirect()->back()->withErrors(['message' => 'Administrador no encontrado.']);
    }
}
