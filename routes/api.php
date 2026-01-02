<?php

use App\Http\Controllers\DevelopmentApplicantController;
use App\Http\Controllers\DevelopmentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventParticipantController;
use App\Http\Controllers\FamilyMemberController;
use App\Http\Controllers\HeadOfFamilyController;
use App\Http\Controllers\ProfileController;
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

Route::apiResource('events', EventController::class);
Route::get('events/all/paginated', [EventController::class, 'getAllPaginated']);

Route::apiResource('event-participants', EventParticipantController::class)
    ->parameters(['event-participants' => 'event_participant']);
Route::get('event-participants/all/paginated', [EventParticipantController::class, 'getAllPaginated']);

Route::apiResource('developments', DevelopmentController::class);
Route::get('developments/all/paginated', [DevelopmentController::class, 'getAllPaginated']);

Route::apiResource('development-applicants', DevelopmentApplicantController::class)
    ->parameters(['development-applicants' => 'development_applicant']);
Route::get('development-applicants/all/paginated', [DevelopmentApplicantController::class, 'getAllPaginated']);

Route::get('profile', [ProfileController::class, 'index']);
Route::post('profile', [ProfileController::class, 'store']);
Route::put('profile', [ProfileController::class, 'update']);
