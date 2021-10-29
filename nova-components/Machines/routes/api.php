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

/**
 * Components
 */
Route::get('/components/{resourceId}', 'ComponentsController@index');
Route::get('/components/{resourceId}/attachments', 'ComponentsController@attachments');
Route::get('/components-config/{resourceId}', 'ComponentsController@config');
Route::post('/components-config', 'ResourceStoreController@handle');


/**
 * Control Plan
 */
Route::get('/control-plan-configs/{resourceId}', 'ControlPlanController@index');