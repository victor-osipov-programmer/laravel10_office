<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $request->validate([
            'position' => ['nullable', 'string'],
            'officeId' => ['nullable', 'integer'],
            'startDate' => ['nullable', 'date_format:Y-m-d'],
        ]);
       
        $employees = Employee::
        when($request->input('position'), 
            fn($query, $value) => $query->where('position', $value)
        )
        ->when($request->input('officeId'), 
            fn($query, $value) => $query->where('officeId', $value)
        )
        ->when($request->input('startDate'), 
            fn($query, $value) => $query->where('startDate', $value)
        )
        ->get();

        return response([
            'status' => 'success',
            'message' => 'OK',
            'data' => [
                'employees' => $employees
            ],
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'firstName' => ['required', 'string'],
            'lastName' => ['required', 'string'],
            'position' => ['required', 'string'],
            'startDate' => ['required', 'date_format:Y-m-d'],
            'officeId' => ['required', 'integer'],
        ]);

        $new_employee = Employee::create($data);

        return response([
            'status' => 'success',
            'message' => 'Сотрудник добавлен',
            'data' => [
                'employee' => [
                    'firstName' => $new_employee->firstName,
                    'lastName' => $new_employee->lastName,
                    'position' => $new_employee->position,
                    'startDate' => $new_employee->startDate,
                ]
            ],
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return response([
            'status' => 'success',
            'message' => 'OK',
            'data' => [
                'employee' => [
                    'firstName' => $employee->firstName,
                    'lastName' => $employee->lastName,
                    'position' => $employee->position,
                    'startDate' => $employee->startDate,
                ]
            ],
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'firstName' => ['required', 'string'],
            'lastName' => ['required', 'string'],
            'position' => ['required', 'string'],
            'startDate' => ['required', 'date_format:Y-m-d'],
            'officeId' => ['required', 'integer'],
        ]);

        $employee->update($data);

        return response([
            'status' => 'success',
            'message' => 'Данные обновлены',
            'data' => [
                'employee' => [
                    'firstName' => $employee->firstName,
                    'lastName' => $employee->lastName,
                    'position' => $employee->position,
                    'startDate' => $employee->startDate,
                ]
            ],
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response()->noContent();
    }
}
