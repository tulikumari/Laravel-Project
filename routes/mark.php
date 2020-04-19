<?php
Route::group(['middleware' => ['auth:front', 'front']], function () {

    Route::get('/book-mark/{caseManagementId}', 'Bookmarks@bookmark')->name('cases.book-mark');
});
