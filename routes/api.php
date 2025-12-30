<?php

use App\Http\Controllers\FamilyMemberController;
use App\Http\Controllers\HeadOfFamilyController;
use App\Http\Controllers\SocialAssistanceController;
use App\Http\Controllers\SocialAssistanceRecipientController;
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

Route::apiResource('social-assistances', SocialAssistanceController::class)
    ->parameters(['social-assistances' => 'social_assistance']);
Route::get('social-assistances/all/paginated', [SocialAssistanceController::class, 'getAllPaginated']);

Route::apiResource('social-assistance-recipients', SocialAssistanceRecipientController::class)
    ->parameters(['social-assistance-recipients' => 'social_assistance_recipient']);
Route::get('social-assistance-recipients/all/paginated', [SocialAssistanceRecipientController::class, 'getAllPaginated']);
