<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\OrederController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceOptionController;
use App\Http\Controllers\TypeController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('generate', function (){
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    echo 'ok';
});

Route::middleware('auth:api')->post('/service-create', [ServiceController::class, 'create']);//создать карточку сервиса(услуги)
Route::get('/service-show/{id}', [ServiceController::class, 'show']);//вывод   карточек  сервиса(услуги)
Route::get('/service-show-admin/{id}', [ServiceController::class, 'showAdmin']); //вывод все карточек сервиса(услуги) для админа
Route::middleware('auth:api')->post('/service-edit', [ServiceController::class, 'edit']);  // Редактировать карточеку сервиса(услуги) для админа
Route::get('/service-index/{id}', [ServiceController::class, 'index']);// вывод карточеки  сервиса(услуги)
Route::middleware('auth:api')->post('/service-destroy', [ServiceController::class, 'destroy']);
Route::post('/type-create', [TypeController::class, 'create']);//создать тип сервиса(услуги)
Route::post('/type-edit',  [TypeController::class, 'edit']);//Редактировать тип сервиса(услуги)
Route::get('/type-show',  [TypeController::class, 'show']);//выводит тип сервиса(услуги)
Route::middleware('auth:api')->post('/service-option-create', [ServiceOptionController::class, 'create']);//создать  услугу
Route::middleware('auth:api')->post('/service-option-edit',  [ServiceOptionController::class, 'edit']);//Редактирование  услугу
Route::get('/service-option-show/{id}',  [ServiceOptionController::class, 'show']);//выводит  одну услугу
Route::middleware('auth:api')->post('/service-option-del',  [ServiceOptionController::class, 'del']);//удаляет  услугу
Route::middleware('auth:api')->post('/comment-create', [CommentController::class, 'create']);//создает  комментарий
Route::middleware('auth:api')->post('/comment-edit',  [CommentController::class, 'edit']);//Редактирование   комментария
Route::get('/comment-show/{id}',  [CommentController::class, 'show']);//выводит все комментарии к заказу
Route::middleware('auth:api')->get('/comment-showadmin',  [CommentController::class, 'showAdmin']);//выводит все комментарии для просмотра админом
Route::post('/get-cart',  [CartController::class, 'getCart']);//выводит все карточки
Route::middleware('auth:api')->post('/editroleid', [AuthController::class, 'editRoleId']);//Изменения ролей пользователей
Route::post('/register', [AuthController::class, 'register']);//регистрация
Route::post('/login',  [AuthController::class, 'login']);//авторизация
Route::middleware('auth:api')->delete('/logout',  [AuthController::class, 'logout']);//выход из приложения
Route::middleware('auth:api')->post('/profil-edit',  [AuthController::class, 'edit']);//Редактирование профиля
Route::middleware('auth:api')->get('/authcheck',  [AuthController::class, 'authCheck']);//проверка на авторизацию пользователя
Route::middleware('auth:api')->get('/authadmincheck', [AuthController::class ,'authAdminCheck']);//проверка на админа
Route::middleware('auth:api')->get('/searchamdimrole',  [SearchController::class, 'searchAmdimRole']);//поиск пользоватлей приложения
Route::get('/search-data',  [SearchController::class, 'searchData']);//поиск услуг
Route::middleware('auth:api')->post('/oreder-create',  [OrederController::class, 'Create']);//создание заказа
Route::middleware('auth:api')->get('/oreder-get',  [OrederController::class, 'GetOrserUserId']);//вывод всех заказов пользователя
Route::middleware('auth:api')->get('/oreder-get-admin',  [OrederController::class, 'GetOrsersAdmin']);//вывод всех заказов пользователя для работников компании
Route::middleware('auth:api')->post('/oreder-edit-admin',  [OrederController::class, 'edit']);//Редактирование заказов  работников компании















