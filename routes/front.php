<?php

/*
|--------------------------------------------------------------------------
| Front Routes
|--------------------------------------------------------------------------
|
| Here is where you can register front routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "front" middleware group. Now create something great!
|
*/

// Login/Logout Routes
Route::get('/login', 'LoginController@showLogin')->name('login');
Route::post('/login', 'LoginController@doLogin')->name('login');
Route::get('/logout', 'LoginController@doLogout')->name('logout');

Route::group(['prefix' => 'password'], function () {
    // Reset request email
    $this->get('reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.forgot');
    $this->post('email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');

    // Reset form
    $this->get('reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    $this->post('reset', 'ResetPasswordController@reset')->name('password.update');
});


Route::group(['middleware' => ['auth:front', 'front']], function () {
	Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/', 'CasesController@index')->name('cases');

    Route::get('/new', 'CasesController@newCase')->name('newcase');
    Route::post('/new', 'CasesController@storeCase')->name('newcase');

    Route::post('/section-flag/{section}/{case}', 'CasesController@flagCaseBySection')->name('section-flag');
    Route::post('/flag-case/{case}', 'CasesController@flagCase')->name('flag-case');

    Route::get('/info/{case}', 'CasesController@caseInfo')->name('caseinfo');
    Route::get('/analysis/{case}', 'CasesController@postAnalysis')->name('analysis');
    Route::get('/author-posts/{case}', 'CasesController@authorPosts')->name('author-posts');
    Route::get('/post-location/{case}', 'CasesController@geoLocationMap')->name('post-location');
    Route::get('/similar-posts/{case}', 'CasesController@similarPosts')->name('similar-posts');
    Route::get('/samearea-posts/{case}', 'CasesController@sameAreaPosts')->name('samearea-posts');
    Route::get('/author-profile/{case}', 'CasesController@authorProfile')->name('author-profile');
    Route::get('/image-search/{case}', 'CasesController@imageSearch')->name('image-search');
    Route::get('/source-cross-check/{case}', 'CasesController@sourceCrossCheck')->name('source-cross');
    Route::get('/results/{case}', 'CasesController@results')->name('results');
    Route::get('/related/{case}', 'CasesController@relatedCases')->name('related');
    Route::get('/cache/{key}', 'CasesController@clearCache')->name('cache');
    Route::get('/discussions/{case}', 'DiscussionController@discussion')->name('discussions');
    Route::post('/discussions/{case}', 'DiscussionController@discussionSave')->name('discussions');

    Route::get('/edit/{case}', 'CasesController@editCase')->name('editcase');
    Route::post('/edit/{case}', 'CasesController@updateCase')->name('editcase');


    /**
      * case management routes
    **/


    Route::get('/case-management', 'CasesController@case_management')->name('cases.management');
    Route::get('/case_search', 'CasesController@case_search')->name('cases.case_search');
    Route::get('/create-case', 'CasesController@create_case')->name('cases.create');
    Route::get('/create-case/{id}', 'CasesController@update_case')->name('cases.update_case');
    Route::get('/detail-case/{id}', 'CasesController@detail_case_desc')->name('cases.detail_case_desc');
    Route::get('/detail-case', 'CasesController@detail_case')->name('cases.detail-case');
    Route::get('/delete-case', 'CasesController@delete_case')->name('cases.delete-case');

    // Add Task routes
    Route::get('/files/{caseManagementId}', 'CasesController@files')->name('cases.files');
    Route::get('/update-task/{caseManagementId}/{id}', 'CasesController@updatetask_case')->name('cases.updatetask_case');
    Route::get('/task-management/{caseManagementId}', 'CasesController@taskmanagement')->name('cases.task-management');
    Route::post('/save-case-management', 'CasesController@save_case_management')->name('cases.save-case-management');
    Route::post('/task-case-management', 'CasesController@task_case_management')->name('cases.task-case-management');
    Route::get('/delete-task-case', 'CasesController@delete_taskcase')->name('cases.delete-task-case');

    // Add notes routes
    Route::get('/notes/{caseManagementId}', 'CasesController@notes')->name('cases.notes');
    Route::get('/add-note/{caseManagementId}', 'CasesController@addNote')->name('cases.addnotes');
    Route::get('/update-note/{caseManagementId}/{id}', 'CasesController@updateNote')->name('cases.update.note');
    Route::get('/view-note/{caseManagementId}/{id}', 'CasesController@viewNote')->name('cases.view.note');
    Route::post('/save-notes', 'CasesController@saveNote')->name('cases.save.notes');
    Route::get('/delete-notes/{caseManagementId}/{id}', 'CasesController@deleteNote')->name('cases.delete.notes');

    // Add Calender Event routes
    Route::get('/case-events/{caseManagementId}', 'EventsController@events')->name('cases.events');
    Route::post('/save-event', 'EventsController@saveEvent')->name('cases.event.save');
    Route::get('/get-event-listing', 'EventsController@getEventListing')->name('cases.event.listing');
    Route::get('/get-event', 'EventsController@getEvent')->name('cases.event.get');
    Route::get('/delete-event', 'EventsController@deleteEvent')->name('cases.event.delete');

    // Add files route
    Route::get('/files-upload/{caseManagementId}', 'FileController@fileUpload')->name('cases.files.upload');
    Route::post('/files-update', 'FileController@updateData')->name('cases.files.update');

    // Add contact  people routes
    Route::get('/contact-people/{caseManagementId}', 'DiscussionController@contact_people')->name('cases.contact-people');
    Route::get('/add-contact/{caseManagementId}', 'DiscussionController@addcontacts')->name('cases.addcontacts');
    Route::post('/save-contact', 'DiscussionController@save_contact')->name('cases.save-contact');
    Route::get('/delete-contact', 'DiscussionController@delete_contact')->name('cases.delete-contact');
    Route::get('/update-contact/{caseManagementId}/{id}', 'DiscussionController@update_contact')->name('cases.update-contact');
	
	Route::get('/cont_search', 'DiscussionController@cont_search')->name('cases.cont_search');
	
	Route::get('/case-discussions/{caseManagementId}', 'CaseDiscussion@casediscussions')->name('cases.case-discussions');
	Route::post('/save-message', 'CaseDiscussion@saveMessage')->name('cases.save-message');
	Route::get('/delete-msg', 'CaseDiscussion@deleteMessage')->name('cases.delete-msg');
	
     //Add bookmark route
     Route::get('/book-mark/{caseManagementId}', 'Bookmarks@bookmark')->name('cases.book-mark');
     Route::post('/save-bookmark', 'Bookmarks@saveBookmark')->name('cases.save-bookmark');
     Route::get('/delete-bookmark', 'Bookmarks@deleteBookmark')->name('cases.delete-bookmark');
     Route::get('/Getbookmarkdata/{caseManagementId}', 'Bookmarks@Get_bookmarkdata')->name('cases.Getbookmarkdata');
     Route::get('/searchYoutube', 'Bookmarks@searchYoutube')->name('cases.searchYoutube');
     Route::get('/searchGoogle', 'Bookmarks@searchGoogle')->name('cases.searchGoogle');
     //Route::get('/searchYoutube', 'Bookmarks@searchYoutube')->name('cases.searchYoutube');
	 
     //Add related cases route
     Route::get('/case-related-cases/{caseManagementId}','RelatedCases@relatedcases')->name('cases.related-cases');
     Route::get('/addrelatedcase/{caseManagementId}', 'RelatedCases@addrelatedcase')->name('cases.addrelatedcase');
     Route::post('/save_rcase', 'RelatedCases@save_rcase')->name('cases.save_rcase');
     Route::get('/relatecase_search', 'RelatedCases@relatecase_search')->name('cases.relatecase_search');
     Route::get('/delete-relate-case/{caseManagementId}}', 'RelatedCases@delete_relate_case')->name('cases.delete-relate-case');
	 
	 //Add map route
	 Route::get('/map/{caseManagementId}', 'MapController@map')->name('cases.map');
	 Route::get('/saveMap', 'MapController@save_Map')->name('cases.saveMap');
	 Route::get('/Getmapdata/{caseManagementId}', 'MapController@Getmapdata')->name('cases.Getmapdata');
	 Route::get('/updateMap', 'MapController@update_Map')->name('cases.updateMap');
	 Route::get('/delete-mapdetail', 'MapController@deleteMap')->name('cases.delete-mapdetail');
	 Route::get('/searchYoutube', 'Bookmarks@searchYoutube')->name('cases.searchYoutube');
	 
	 
	 //Security route
	 Route::get('/security/{caseManagementId}', 'SecurityController@index')->name('cases.security');
   Route::get('/getSecureUser/{caseManagementId}', 'SecurityController@getSecureUser')->name('cases.getSecureUser');
   Route::get('/removeSecureUser', 'SecurityController@removeSecureUser')->name('cases.removeSecureUser');
   Route::get('/addSecureUser', 'SecurityController@addSecureUser')->name('cases.addSecureUser');
   Route::get('/getUserslist/{caseManagementId}', 'SecurityController@getUserslist')->name('cases.getUserlist');

});
