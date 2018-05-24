<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// admin
Route::post('/attendance/admin/login','AdminController@login');
Route::post('/attendance/admin/add_admin','AdminController@add_admin');
Route::post('/attendance/admin/add_tutor','AdminController@add_tutor');
Route::post('/attendance/admin/add_student','AdminController@add_student');
Route::post('/attendance/admin/add_hall','AdminController@add_hall');
Route::post('/attendance/admin/update_student','AdminController@update_student');
Route::post('/attendance/admin/update_tutor','AdminController@update_tutor');
Route::get('/attendance/admin/get_students','AdminController@get_students');
Route::get('/attendance/admin/get_tutors','AdminController@get_tutors');
// student
Route::post('/attendance/student/login','StudentController@login');
Route::post('/attendance/student/attend_session','StudentController@attend_session');
Route::get('/attendance/student/get_student/{id}','StudentController@get_student');
Route::get('/attendance/student/get_sessions','StudentController@get_sessions');
Route::get('/attendance/student/get_date_now','StudentController@get_date_now');
Route::get('/attendance/student/get_sessions_student/{id}','StudentController@get_sessions_student');
// tutor
Route::post('/attendance/tutor/login','TutorController@login');
Route::post('/attendance/tutor/add_session','TutorController@add_session');
Route::get('/attendance/tutor/get_sessions/{id}','TutorController@get_sessions');
Route::get('/attendance/tutor/get_halls','TutorController@get_halls');
Route::get('/attendance/tutor/get_sessions_now/{id}','TutorController@get_sessions_now');
Route::post('/attendance/tutor/regist_student','TutorController@regist_student');
Route::post('/attendance/tutor/attend_student','TutorController@attend_student');
