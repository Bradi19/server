<?php

use App\Http\Controllers\FormsController;
use App\Http\Middleware\CheckAge;
use App\Http\Resources\Projects as ResourcesProjects;
use App\Http\Resources\UserResource;
use App\Models\Banner;
use App\Models\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => CheckAge::class],function () {
    Route::get('/banner', function (Request $request) {
            return new UserResource(Banner::all());
    });
    Route::get('/projects', function (Request $request) {
        $all = Projects::all();
        return new ResourcesProjects($all);
    });
    Route::post('/projectOne', function(Request $request)
    {
        $id = (int)$request->input('id');
        $one = Projects::find($id);
        return response()->json($one);

    });
    Route::post('/forms', [FormsController::class, 'checkForm']);
});
