<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. You're free to add
| as many additional routes to this file as your tool may require.
|
*/

Route::get('/activities/new/{resourceId}', 'ActivitiesController@new');
Route::get('/activities/old/{resourceId}', 'ActivitiesController@old');
Route::get('/machines/{resourceId}/duplicate', 'MachinesController@duplicate');
Route::post('/breadcrumb', 'BreadcrumbController@index');
Route::get('/anomalies/{resourceId}', 'MachinesController@anomalies');
