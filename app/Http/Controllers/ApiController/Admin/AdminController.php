<?php

namespace App\Http\Controllers\ApiController\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Http\Resources\AdminResource;
use App\Traits\ApiResponseTrait; // Ensure this trait exists in the specified namespace
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $admins = AdminResource::collection(Admin::all());
        return $this->successResponse($admins, 'Admins retrieved successfully.');
    }

    public function show($id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            return $this->errorResponse('Admin not found', 404);
        }
        return $this->successResponse(new AdminResource($admin), 'Admin retrieved successfully.');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins',
            'password' => 'required|string|min:8',
            'phone_number' => 'nullable|string|max:15',
            'admin_image' => 'required|string|max:255',
        ];

        // Create the validator instance
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            // Return the first validation error message
            return $this->errorResponse($validator->errors()->first(), 422);
        }
        $data=$request->all();

        $data['password'] = Hash::make($data['password']);
        $admin = Admin::create($data);

        return $this->successResponse(new AdminResource($admin), 'Admin created successfully.', 201);
    }

    public function update(Request $request, $id)
    {
        // Define the validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins',
            'password' => 'required|string|min:8',
            'phone_number' => 'nullable|string|max:15',
            'admin_image' => 'required|string|max:255',
        ];

        // Create the validator instance
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            // Return the first validation error message
            return $this->errorResponse($validator->errors()->first(), 422);
        }

        // Get the validated data
        $validated = $validator->validated();

        // Check if password is provided and hash it
        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        // Find the admin by ID and update the data
        $admin = Admin::findOrFail($id);
        $admin->update($validated);

        // Return the success response with the updated admin data
        return $this->successResponse(new AdminResource($admin), 'Admin updated successfully.');
    }

    public function destroy($id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            return $this->errorResponse('Admin not found', 404);
        }

        $admin->delete();
        return $this->successResponse(null, 'Admin deleted successfully.', 200);
    }
}