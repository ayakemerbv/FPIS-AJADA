<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Employee;
use App\Models\Manager;
use App\Models\Student;
use App\Models\User;
use App\Notifications\UserCredentials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;
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
        $plainPassword = $request->password;

        $user = User::create([
            'name' => $request->name,
            'user_id' => $request->user_id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        switch ($user->role) {
            case 'student':
                Student::create([
                    'user_id' => $user->id,
                    'student_id' => $user->id,
                    'room_id' => null,
                ]);
                break;
            case 'manager':
                Manager::create([
                    'user_id' => $user->id,
                    'manager_id' => $user->id,
                ]);
                break;
            case 'admin':
                Admin::create([
                    'user_id' => $user->id,
                    'admin_id' => $user->id,
                ]);
                break;
            case 'employee':
                Employee::create([
                    'user_id' => $user->id,
                    'employee_id' => $user->id,
                    'name' => $user->name,
                    'job_type' => $request->job_type ?? 'Не указано',
                ]);
                break;
        }
        try {
            Mail::raw(
            "Здравствуйте!\n\n" .
            "Вы были зарегистрированы в системе DMS.\n\n" .
            "Ваши учетные данные для входа:\n" .
            "ID пользователя: {$request->user_id}\n" .
            "Email: {$request->email}\n" .
            "Пароль: {$plainPassword}\n\n" .
            "Рекомендуем сменить пароль после первого входа.",
            function (Message $message) use ($request) {
                $message->to($request->email)
                    ->subject('Ваши учетные данные для входа в DMS');
            }
        );
            \Log::info('Email sent successfully', [
                'to' => $request->email
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to send email', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }


        return redirect()->route('admin.dashboard')
            ->with('successType', 'user_created');
    }

    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('filter_id')) {
            $query->where('user_id', 'like', '%'.$request->filter_id.'%');
        }
        if ($request->filled('filter_name'))                                                                                            {
            $query->where('name', 'like', '%'.$request->filter_name.'%');
        }
        if ($request->filled('filter_email')) {
            $query->where('email', 'like', '%'.$request->filter_email.'%');
        }
        if ($request->filled('filter_role')) {
            $query->where('role', 'like', '%'.$request->filter_role.'%');
        }

        $users = $query->get();
        session()->flash('successType', 'user_searched');
        session()->flash('success', 'Пользователь найден!');
        return view('admin.dashboard', [
            'users' => $users,
            'newsList' => collect(),
        ]);
    }
    public function destroy($id)
    {
        Log::info("Deleting user with ID: $id");
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.dashboard')
            ->with('successType', 'user_deleted');
    }
    public function getUserJson($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'Пользователь не найден'], 404);
        }
        return response()->json($user);
    }
}
