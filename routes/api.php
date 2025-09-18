<?php

use App\Http\Controllers\Company\{
    CompanyController,
    DigitalCertificationController,
    EmployeeController
};
use App\Http\Controllers\People\{
    AddressController,
    EmailController,
    PeopleController,
    PhoneController
};
use App\Http\Controllers\Product\{
    ProductController,
    ProductTaxController
};
use App\Http\Controllers\Service\{
    ServiceController,
    ServiceTaxController
};
use App\Http\Controllers\System\{
    AuthController,
    PermissionController,
    RoleController,
    UserController
};
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});

Route::middleware('jwt')->group(function () {
    /* System */
    Route::group([], function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
    });
    Route::group([], function () {
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
    Route::group([], function () {
        Route::apiResource('roles', RoleController::class);
    });
    Route::group([], function () {
        Route::apiResource('permissions', PermissionController::class);
    });
    
    /* Company */
    Route::group([], function () {
        Route::apiResource('companies', CompanyController::class);
    });
    Route::group([], function () {
        Route::apiResource('employees', EmployeeController::class);
    });
    Route::group([], function () {
        Route::apiResource('digital-certifications', DigitalCertificationController::class);
    });

    /* People */
    Route::group([], function () {
        Route::apiResource('people', PeopleController::class);
    });
    Route::group([], function () {
        Route::apiResource('addresses', AddressController::class);
    });
    Route::group([], function () {
        Route::apiResource('phones', PhoneController::class);
    });
    Route::group([], function () {
        Route::apiResource('emails', EmailController::class);
    });
    Route::group([], function () {
        Route::apiResource('vehicles', DigitalCertificationController::class);
    });

    /* Product */
    Route::group([], function () {
        Route::apiResource('products', ProductController::class);
    });
    Route::group([], function () {
        Route::apiResource('products.taxes', ProductTaxController::class);
    });

    /* Service */
    Route::group([], function () {
        Route::apiResource('services', ServiceController::class);
    });
    Route::group([], function () {
        Route::apiResource('services.taxes', ServiceTaxController::class);
    });

    /* Finance */
    Route::group([], function () {
        Route::apiResource('accounts-payable', ServiceController::class);
    });
    Route::group([], function () {
        Route::apiResource('accounts-receivable', ServiceTaxController::class);
    });
    Route::group([], function () {
        Route::apiResource('financial-transaction', ServiceController::class);
    });
    Route::group([], function () {
        Route::apiResource('payment-method', ServiceTaxController::class);
    });
});
