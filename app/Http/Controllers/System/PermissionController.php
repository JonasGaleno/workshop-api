<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\System\PermissionRegisterRequest;
use App\Http\Requests\System\PermissionUpdateRequest;
use App\Services\System\PermissionService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct(
        protected PermissionService $permissionService
    ) {
    }

    public function index(Request $request)
    {
        try {
            $permissions = $this->permissionService->all($request);

            return response()->json($permissions, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for Permissions',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(int $id)
    {
        try {
            $permission = $this->permissionService->find($id);

            return response()->json($permission, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for Permission',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(PermissionRegisterRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $permission = $this->permissionService->register($validatedData);

            return response()->json($permission, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(PermissionUpdateRequest $request, int $id)
    {
        try {
            $validatedData = $request->validated();

            $permission = $this->permissionService->update($validatedData, $id);

            return response()->json($permission, 200);
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
            $this->permissionService->delete($id);

            return response()->json(['message' => 'Permission deleted'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
