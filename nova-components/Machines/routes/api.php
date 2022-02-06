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
 * Machines
 */
Route::get('/machines/{resourceId}/attachments', 'MachinesController@attachments');

/**
 * Components
 */
Route::get('/components/{resourceId}', 'ComponentsController@index');
Route::get('/components/{resourceId}/attachments', 'ComponentsController@attachments');
Route::get('/components-config/{resourceId}', 'ComponentsController@config');
Route::post('/components-config', 'ResourceStoreController@handle');
Route::post('/components-config/{id}', 'ResourceStoreController@updateComponentConfig');
Route::get('/components-config/{componentId}/{position}', 'ComponentsController@getConfig');

/**
 * Control Plan
 */
Route::get('/control-plan-configs/{resourceId}', 'ControlPlanController@index');
Route::get('/control-plans/{controlPlanId}/edit', 'ControlPlanController@editControlPlan');
Route::get('/control-plans/{machineId}', 'ControlPlanController@getControlPlan');
Route::get('/measurements/{controlPlanId}/{position}', 'ControlPlanController@getMeasurement');
Route::get('/measurements-image/{measurementId}', 'ImageController@getImage');
Route::post('/control-plans-configs', 'ResourceStoreController@createControlPlanConfig');
Route::post('/control-plans-configs/{controlPlanId}', 'ResourceStoreController@updateControlPlanConfig');
Route::post('/control-plans/{controlPlanId}', 'ResourceStoreController@updateControlPlan');
Route::post('/components/{measurementId}', 'ResourceStoreController@updateComponent');
