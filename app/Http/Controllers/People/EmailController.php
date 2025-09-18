<?php

namespace App\Http\Controllers\People;

use App\Http\Controllers\Controller;
use App\Http\Requests\People\EmailRegisterRequest;
use App\Http\Requests\People\EmailUpdateRequest;
use App\Services\People\EmailService;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function __construct(
        protected EmailService $emailService
    ) {
    }

    public function index(Request $request)
    {
        try {
            $emails = $this->emailService->all($request);

            return response()->json($emails, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for Emails',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(int $id)
    {
        try {
            $email = $this->emailService->find($id);

            return response()->json($email, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for the Email',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(EmailRegisterRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $email = $this->emailService->register($validatedData);

            return response()->json($email, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(EmailUpdateRequest $request, int $id)
    {
        try {
            $validatedData = $request->validated();

            $email = $this->emailService->update($validatedData, $id);

            return response()->json($email, 200);
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
            $this->emailService->delete($id);

            return response()->json(['message' => 'Email deleted'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
