<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\System\RoleRegisterRequest;
use App\Http\Requests\System\RoleUpdateRequest;
use App\Services\System\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct(
        protected RoleService $roleService
    ) {
    }

    public function index(Request $request)
    {
        try {
            $roles = $this->roleService->all($request);

            return response()->json($roles, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for Roles',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(int $id)
    {
        try {
            $role = $this->roleService->find($id);

            return response()->json($role, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for Role',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(RoleRegisterRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $role = $this->roleService->register($validatedData);

            return response()->json($role, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(RoleUpdateRequest $request, int $id)
    {
        try {
            $validatedData = $request->validated();

            $role = $this->roleService->update($validatedData, $id);

            return response()->json($role, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->roleService->delete($id);

            return response()->json(['message' => 'Role deleted'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
