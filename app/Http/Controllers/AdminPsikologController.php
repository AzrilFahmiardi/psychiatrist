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
    public function update(Request $request, User $psikolog)
    {
        
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $psikolog->id,
            'password' => 'nullable|string|min:6',
            'confirmPassword' => 'nullable|same:password',
        ]);
        // dd($psikolog->nama_lengkap, $request->nama_lengkap);
        $psikolog->nama_lengkap = $request->nama_lengkap;
        $psikolog->email = $request->email;

        if ($request->filled('password')) {
            $psikolog->password = Hash::make($request->password);
        }

        $psikolog->save();

        $psikolog = Psikolog::where('user_id', $psikolog->id)->first();
        $psikolog->nama_lengkap = $request->nama_lengkap;
        $psikolog->email = $request->email;
        $psikolog->name = $request->nama_lengkap;

        $psikolog->save();

        return redirect()->route('admin.psikologs.index')->with('success', 'Psikolog updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $psikolog)
    {
        // dd($psikolog->id);
        $psikologFind = Psikolog::where('user_id', $psikolog->id)->first();
        // dd($psikologFind);
        $psikologFind->delete();
        $psikolog->delete();
        return redirect()->route('admin.psikologs.index')->with('success', 'Psikolog deleted successfully.');
    }
}
