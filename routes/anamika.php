<?php
Route::group(['middleware' => ['auth:front', 'front']], function () {

     Route::get('/case-discussions/{caseManagementId}', 'CaseDiscussion@casediscussions')->name('cases.case-discussions');
     Route::post('/save-message', 'CaseDiscussion@saveMessage')->name('cases.save-message');
     Route::get('/delete-msg', 'CaseDiscussion@deleteMessage')->name('cases.delete-msg');
     //route for contact people search
     Route::get('/cont_search', 'DiscussionController@cont_search')->name('cases.cont_search');
     //route for bookmarks 
     Route::get('/book-mark/{caseManagementId}', 'Bookmarks@bookmark')->name('cases.book-mark');
     Route::post('/save-bookmark', 'Bookmarks@saveBookmark')->name('cases.save-bookmark');
     Route::get('/delete-bookmark', 'Bookmarks@deleteBookmark')->name('cases.delete-bookmark');
     Route::get('/Getbookmarkdata/{caseManagementId}', 'Bookmarks@Get_bookmarkdata')->name('cases.Getbookmarkdata');
     //route for related cases
     Route::get('/case-related-cases/{caseManagementId}','RelatedCases@relatedcases')->name('cases.related-cases');
     Route::get('/addrelatedcase/{caseManagementId}', 'RelatedCases@addrelatedcase')->name('cases.addrelatedcase');
     Route::post('/save_rcase', 'RelatedCases@save_rcase')->name('cases.save_rcase');
     Route::get('/relatecase_search', 'RelatedCases@relatecase_search')->name('cases.relatecase_search');

});
