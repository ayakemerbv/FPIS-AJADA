<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:student,manager,admin,employee',
            'job_type' => 'nullable|string|max:255',
        ]);

        $user=User::create([
            'name' => $request->name,
            'user_id' => $request->user_id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        if ($user->role === 'student') {
            Student::create([
                'user_id' => $user->id,
                'student_id' => $user->id, // Если student_id = user_id
                'room_id' => null, // Пока нет комнаты, обновится позже
            ]);
        }
        elseif ($user->role === 'employee') {
            Employee::create([
                'user_id' => $user->id,
                'employee_id' => $user->id,
                'name' => $user->name,
                'job_type' => $request->job_type ?? 'Не указано',
            ]);
        }


        return redirect()->route('admin.dashboard')
            ->with('successType', 'user_created')
            ->with('success', 'Пользователь создан!');
    }

    public function index()
    {
        $users = User::all();
        return view('admin.dashboard', compact('users'));
    }

}
