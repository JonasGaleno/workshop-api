<?php

namespace App\Http\Controllers\People;

use App\Http\Controllers\Controller;
use App\Http\Requests\People\PeopleRegisterRequest;
use App\Http\Requests\People\PeopleUpdateRequest;
use App\Services\People\PeopleService;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    public function __construct(
        protected PeopleService $peopleService
    ) {
    }

    public function index(Request $request)
    {
        try {
            $people = $this->peopleService->all($request);

            return response()->json($people, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for People',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(int $id)
    {
        try {
            $person = $this->peopleService->find($id);

            return response()->json($person, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for the Person',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(PeopleRegisterRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $person = $this->peopleService->register($validatedData);

            return response()->json($person, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(PeopleUpdateRequest $request, int $id)
    {
        try {
            $validatedData = $request->validated();

            $person = $this->peopleService->update($validatedData, $id);

            return response()->json($person, 200);
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
            $this->peopleService->delete($id);

            return response()->json(['message' => 'Person deleted'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
