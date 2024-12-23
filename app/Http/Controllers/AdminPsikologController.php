<?php

namespace App\Http\Controllers;

use App\Models\Psikolog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminPsikologController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua user dengan role psikolog
        $psikologs = User::where('role', 'psikolog')->get();

        return view('admin.psikologs.index', compact('psikologs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.psikologs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'confirmPassword' => 'required|same:password',
        ]);

        $user = User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'name' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password), // hash password
            'role' => 'psikolog',
        ]);

        Psikolog::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'name' => $request->nama_lengkap,
            'user_id' => $user->id,
        ]);

        return redirect()->route('admin.psikologs.index')->with('success', 'Psikolog created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $psikolog)
    {
        return view('admin.psikologs.edit', compact('psikolog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
        ]);

        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        $psikolog = Psikolog::where('user_id', $user->id)->first();
        $psikolog->nama_lengkap = $request->nama_lengkap;
        $psikolog->email = $request->email;
        $psikolog->name = $request->nama_lengkap;

        $psikolog->save();

        return redirect()->route('admin.psikologs.index')->with('success', 'Psikolog updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $psikolog = Psikolog::where('user_id', $user->id)->first();
        $user->delete();
        return redirect()->route('admin.psikologs.index')->with('success', 'Psikolog deleted successfully.');
    }
}
