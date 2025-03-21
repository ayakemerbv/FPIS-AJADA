<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Request as RepairRequest;

class EmployeeController extends Controller
{
    //

    public function dashboard(){
        return view('employee.dashboard');
    }
    public function requests(){
        $repairRequests = RepairRequest::all();
        return view('employee.requests', compact('repairRequests'));
    }
    public function show($id){
        $request = RepairRequest::with('employee')->findOrFail($id);
        return view('employee.show', compact('request'));

    }
    public function edit($id){
        $request = RepairRequest::findOrFail($id); // Ищем по ID

        return view('employee.edit', compact('request'));
    }
    public function update(Request $httpRequest, $id){
        $employee = Employee::where('user_id', auth()->id())->first();
        if (!$employee) {
            return redirect()->back()->with('error', 'Вы не зарегистрированы как сотрудник.');
        }
        $request = RepairRequest::where('id', $id)
            ->where('employee_id', $employee->id)
            ->first();
//        dd($request);

        if (!$request) {
            return redirect()->back()->with('error', 'Запрос не найден или у вас нет доступа.');
        }

        $request->update(['status' => $httpRequest->input('status')]);

        return redirect()->route('employee.requests')->with('success', 'Статус успешно обновлён.');

    }
}
