<?php

use App\Http\Controllers\InstituteController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;

Route::group(['middleware' => 'guest'], function() {
    Route::get('/', function () {
        return view('Login_form');
    })->name('login');

    Route::get('/register',[RegisterController::class,'registerForm'])->name('register-form');
    Route::post('/register', [RegisterController::class,'register'])->name('register');

    Route::get('/forgot_password', [UserController::class,'forgotPassword'])->name('forgot-password');
    Route::post('/forgot_password', [UserController::class,'resetPassword'])->name('reset-password');
    Route::get('/recreate_password/{token}',[RegisterController::class, 'recreatePassword'])->name('recreate_password');
    Route::post('/update_password/{token}', [RegisterController::class, 'updatePassword'])->name('update_password');
    Route::post('/login1', [UserController::class,'login'])->name('login-form');
});



Route::group(['middleware'=>'auth'], function (){
    Route::get('/dashboard/filter/sort',[UserController::class,'sort']);
    Route::get('/dashboard', [UserController::class,'dashboard'])->name('dashboard');
    Route::get('/dashboard/search', [UserController::class,'search'])->name('search');
    Route::get('/dashboard/filter',[UserController::class,'filter'])->name('filter');
    Route::get('/create_cv', [UserController::class,'create_cv'])->name('create_cv');
    Route::get('/editCV/{id}', [UserController::class,'Edit_cv'])->name('editCV');

    Route::post('/education', [UserController::class,'Education'])->name('education');
    Route::get('/create_education', [UserController::class,'CreateEducation'])->name('create_education');
    Route::post('/create_education', [UserController::class,'AddEducation'])->name('add_edcuation');

    Route::get('/education_dashboard', [UserController::class,'EducationDashboard'])->name('education_dash');
    Route::get('/editEducation/{id}', [UserController::class,'editEducationForm'])->name('edit_edu_form');
    Route::post('/editEducation/{id}', [UserController::class,'editEducation'])->name('edit_edu');

//    Route::get('/roles', [UserController::class,'roles'])->name('roles');
//    Route::post('/roles', [UserController::class,'find_roles'])->name('find_roles');
//
//    Route::get('/terminal',[UserController::class,'terminal'])->name('terminal');
//    Route::post('/terminal', [UserController::class,'payTerminal'])->name('payTerminal');

    Route::get('/addEducationForEmp/{id}', [UserController::class,'newEmployerEducation']);

    Route::get('/changePhoneCode/', [UserController::class, 'phoneCode']);

    Route::post('/saveCV/{id}', [UserController::class,'Update_cv'])->name('updateCV');
    Route::delete('/deleteCV/{id}', [UserController::class,'Delete_cv']);
    Route::delete('/deleteFile/{id}', [UserController::class,'delete_file']);
    Route::delete('/deleteEducation/{id}', [UserController::class,'DeleteEdu']);
    Route::delete('/editEducation/deleteFac/{id}',[UserController::class,'DeleteFac']);

    Route::get('/view_cv/{id}',[UserController::class,'viewCv'])->name('view_cv');


    Route::post('/add_cv', [UserController::class,'Add_cv'])->name('add_cv');

    Route::post('/education_dashboard/uploadUni', [InstituteController::class,'uploadUni'])->name('uploadUni');

    Route::get('/logout1', [UserController::class,'logout1'])->name('logout1');
});

//Route::group(['prefix' => 'admin',  'middleware' => 'auth'], function()
//{
//    //All the routes that belongs to the group goes here
//    Route::get('dashboard', function() {} );
//});
//Auth::routes();

