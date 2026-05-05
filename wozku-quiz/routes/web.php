<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;

Route::get('/', function () {
    return redirect('/quizzes');
});

Route::get('/quizzes', [QuizController::class, 'index']);
Route::get('/quizzes/create', [QuizController::class, 'create']);
Route::post('/quizzes/store', [QuizController::class, 'store']);

Route::get('/quizzes/{quiz}/questions/create', [QuizController::class, 'questionCreate']);
Route::post('/quizzes/{quiz}/questions/store', [QuizController::class, 'questionStore']);

Route::get('/quizzes/{quiz}/attempt', [QuizController::class, 'attempt']);
Route::post('/quizzes/{quiz}/submit', [QuizController::class, 'submit']);

Route::get('/attempts/{attempt}', [QuizController::class, 'result']);

Route::delete('/questions/{question}', [QuizController::class, 'deleteQuestion']);