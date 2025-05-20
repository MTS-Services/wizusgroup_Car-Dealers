<?php


use App\Http\Controllers\Backend\DatatableController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


use App\Http\Controllers\Backend\FileManagementController;

Route::post('update/sort/order', [DatatableController::class, 'updateSortOrder'])->name('update.sort.order');
// File Management
Route::controller(FileManagementController::class)->prefix('file-management')->name('file.')->group(function () {
    Route::post('/upload-temp-file', 'uploadTempFile')->name('upload_tf');
    Route::delete('/delete-temp-file', 'deleteTempFile')->name('delete_tf');
    Route::post('/reset-file-file', 'resetTempFile')->name('reset_tf');
    // Route::post('/cleanup-temp-files', 'cleanupTempFiles')->name('cleanup_tf');
    Route::post('/delete-unsaved-temp-files', 'deleteUnsavedTempFiles')->name('du_tf');
    Route::post('/content-image/upload', 'content_image_upload')->name('ci_upload');
     

});

require __DIR__ . '/admin.php';
require __DIR__ . '/user.php';
require __DIR__ . '/frontend.php';
