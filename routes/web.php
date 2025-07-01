<?php

use App\Http\Controllers\GitHubController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'github/issues');

Route::prefix('github')->name('github.')->group(function () {
    Route::get('/issues', [GitHubController::class, 'myAssignedIssues'])->name('issues');
    Route::get('/issue/details/{owner}/{repo}/{id}', [GitHubController::class, 'issueDetails'])->name('issue.details');
});