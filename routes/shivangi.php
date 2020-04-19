<?php
Route::group(['middleware' => ['auth:front', 'front']], function () {
      Route::get('/map/{caseManagementId}', 'MapController@map')->name('cases.map');
      Route::get('/saveMap', 'MapController@save_Map')->name('cases.saveMap');
      Route::get('/Getmapdata/{caseManagementId}', 'MapController@Getmapdata')->name('cases.Getmapdata');
      Route::get('/updateMap', 'MapController@update_Map')->name('cases.updateMap');
      Route::get('/delete-mapdetail', 'MapController@deleteMap')->name('cases.delete-mapdetail');
});
