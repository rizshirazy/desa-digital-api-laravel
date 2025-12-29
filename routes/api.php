<?php

use App\Http\Controllers\FamilyMemberController;
use App\Http\Controllers\HeadOfFamilyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UserController::class);
Route::get('users/all/paginated', [UserController::class, 'getAllPaginated']);

Route::apiResource('head-of-families', HeadOfFamilyController::class)
    ->parameters(['head-of-families' => 'head_of_family']);
Route::get('head-of-families/all/paginated', [HeadOfFamilyController::class, 'getAllPaginated']);

Route::apiResource('family-members', FamilyMemberController::class)
    ->parameters(['family-members' => 'family_member']);
Route::get('family-members/all/paginated', [FamilyMemberController::class, 'getAllPaginated']);
