<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegisteredUserController extends Controller
{
    public function create()
    {
        // Ambil daftar department dari table departments
        $departments = Department::all();

        // Ambil daftar division unik dari table users
        $divisions = User::select('division')->distinct()->get();

        return view('auth.register', compact('departments', 'divisions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => ['required', 'string', 'max:45'],
            'full_name' => ['required', 'string', 'max:100'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'department' => ['required', 'exists:departments,iddepartments'],
            'division' => ['required', Rule::exists('users', 'division')],
        ]);

        User::create([
            'nik' => $request->nik,
            'full_name' => $request->full_name,
            'password' => Hash::make($request->password),
            'departments_iddepartments' => $request->department,
            'division' => $request->division,
            'role' => 'Users'
        ]);

        return redirect()->route('login')->with('status', 'Registration successful! Please log in.');
    }
}

