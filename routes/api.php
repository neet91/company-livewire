<?php

use App\Http\Resources\CompanyResource;
use App\Models\CompanyAlpine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/companies/{company}', function (CompanyAlpine $company) {
    return new CompanyResource(
        $company->load('employees')->loadCount('employees')
    );
});

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
