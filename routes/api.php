<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\Api\QuizController;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\MaterialController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\API\InstructorController;
use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\Api\QuizSubmissionController;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;


#public route
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgotpassword', [AuthController::class, 'sendResetLink']);
Route::post('/resetpassword', [AuthController::class, 'reset']);
Route::options('/{any}', function () {
    return response()->json([], 200);
})->where('any', '.*');

#privet route
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware([EnsureFrontendRequestsAreStateful::class,'auth:sanctum'])->group(function () {

    Route::get('/user', function (Request $request) {return $request->user();});
    Route::get('/pending_users', [AdminController::class, 'getPendingUsers']);
    Route::post('/users/{id}/approve', [AdminController::class, 'approveUser']);
    Route::post('/users/{id}/reject', [AdminController::class, 'rejectUser']);

    Route::prefix('courses')->name('courses.')->group(function () {
        Route::get('/', [CourseController::class, 'index']);
        Route::get('/myCourses', [CourseController::class, 'myCourses']);
        Route::get('/{id}', [CourseController::class, 'show']);
        Route::post('/store', [CourseController::class, 'store']);
        Route::post('/update/{id}', [CourseController::class, 'update']);
        Route::delete('/destroy/{id}', [CourseController::class, 'destroy']);
    });

    Route::get('/profile', [ProfileController::class, 'show']);
    Route::post('/profileupdate', [ProfileController::class, 'update']);
    Route::post('/profilechangepassword', [ProfileController::class, 'changePassword']);
    // Route::post('/profiledelete', [ProfileController::class, 'deleteAccount']);

    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('/myPosts', [PostController::class, 'myPosts']);
        Route::get('/', [PostController::class, 'index']);
        Route::post('/storeComment/{post_id}', [PostController::class, 'storeComment']);
        Route::post('/store', [PostController::class, 'store']);
        Route::post('/show/{id}', [PostController::class, 'show']);
        Route::post('/update/{id}', [PostController::class, 'update']);
        Route::delete('/destroy/{id}', [PostController::class, 'destroy']);
    });

    Route::prefix('instructors')->name('instructors.')->group(function () {
        Route::get('/', [InstructorController::class, 'index']);
        Route::get('/{id}', [InstructorController::class, 'show']);
    });

    Route::post('/quizzes', [QuizController::class, 'index']);
    Route::post('/quizzes/{quiz_id}/submit', [QuizSubmissionController::class, 'submit']);
    Route::get('/submissions/{submission}', [QuizSubmissionController::class, 'show']);

    Route::prefix('quizzes')->group(function () {
        Route::get('/', [QuizController::class, 'index']);
        Route::post('/', [QuizController::class, 'store']);
        Route::get('{id}', [QuizController::class, 'show']);
        Route::post('update/{id}', [QuizController::class, 'update']);
        Route::delete('{id}', [QuizController::class, 'destroy']);
    });
    Route::prefix('questions')->group(function () {
        Route::get('/', [QuestionController::class, 'index']);
        Route::post('/', [QuestionController::class, 'store']);
        Route::get('{id}', [QuestionController::class, 'show']);
        Route::post('update/{id}', [QuestionController::class, 'update']);
        Route::delete('{id}', [QuestionController::class, 'destroy']);
    });
    Route::get('/levels', [LevelController::class, 'index']);
    Route::get('/download/{id}', [MaterialController::class, 'download']);

    Route::prefix('materials')->name('materials.')->group(function () {
        Route::get('/', [MaterialController::class, 'index']);
        Route::post('/', [MaterialController::class, 'store']);
        Route::get('/{id}', [MaterialController::class, 'show']);
        Route::post('/update/{id}', [MaterialController::class, 'update']);
        Route::delete('/destroy/{id}', [MaterialController::class, 'destroy']);
    });
});
