<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\DigitalCertificationRegisterRequest;
use App\Http\Requests\Company\DigitalCertificationUpdateRequest;
use App\Services\Company\DigitalCertificationService;
use Illuminate\Http\Request;

class DigitalCertificationController extends Controller
{
    public function __construct(
        protected DigitalCertificationService $digitalCertificationService
    ) {
    }

    public function index(Request $request)
    {
        try {
            $digitalCertifications = $this->digitalCertificationService->all($request);

            return response()->json($digitalCertifications, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for Digital Certifications',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(int $id)
    {
        try {
            $digitalCertification = $this->digitalCertificationService->find($id);

            return response()->json($digitalCertification, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for the Digital Certification',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(DigitalCertificationRegisterRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $digitalCertification = $this->digitalCertificationService->register($validatedData);

            return response()->json($digitalCertification, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(DigitalCertificationUpdateRequest $request, int $id)
    {
        try {
            $validatedData = $request->validated();

            $digitalCertification = $this->digitalCertificationService->update($validatedData, $id);

            return response()->json($digitalCertification, 200);
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
            $this->digitalCertificationService->delete($id);

            return response()->json(['message' => 'Digital Certification deleted'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
