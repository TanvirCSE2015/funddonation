<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DonationController;
use App\Http\Controllers\Admin\NoteController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\MessageTemplateController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth'])->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/admin/dashboard', 'index')->name('admin.dashboard');
        Route::get('/admin/edit-admin', 'EditAdmin')->name('admin.editadmin');
    });

    Route::controller(TypeController::class)->group(function () {
        Route::get('/admin/types', 'TypeList')->name('admin.typelist');
        Route::get('/admin/add-type', 'AddType')->name('admin.addtype');
        Route::post('/admin/insert-type', 'InserType')->name('admin.inserttype');
        Route::get('/admin/edit-type/{id}', 'EditType')->name('admin.edittype');
        Route::post('/admin/update-type', 'UpdateType')->name('admin.updatetype');
        Route::get('/admin/delete-type/{id}', 'DeleteType')->name('admin.deletetype');
    });
    Route::controller(UserController::class)->group(function () {
        Route::get('/admin/users/{num?}', 'UserList')->name('admin.userlist');
        Route::get('/admin/add-user', 'AddUser')->name('admin.adduser');
        Route::post('/admin/insert-user', 'InsertUser')->name('admin.insertuser');
        Route::get('/admin/edit-user/{id}', 'EditUser')->name('admin.edituser');
        Route::post('/admin/update-user/{id}', 'UpdateUser')->name('admin.updateuser');
        Route::get('/admin/delete-user/{id}', 'DeleteUser')->name('admin.deleteuser');
        Route::get('admin/search','SearchUser')->name('search');
        Route::get('/admin/user-details/{id}/{year?}', 'UserDetails')->name('admin.userdetails');
    });
    Route::controller(DonationController::class)->group(function () {
        Route::get('/admin/new-donation', 'NewDonation')->name('admin.newdonation');
        Route::post('/admin/insert-new-donation', 'InsertNewDonation')->name('admin.insertnewdonation');
        Route::get('/admin/add-donation/{id}', 'AddDonation')->name('admin.adddonation');
        Route::post('/admin/insert-donation/{id}', 'InsertDonation')->name('admin.insertdonation');
        Route::get('/admin/daily-donation', 'DailyDonation')->name('admin.dailydonation');
        Route::get('/admin/permonth-donation/{month?}/{year?}', 'PermonthDonation')->name('admin.permonthdonation');
        Route::get('/admin/missing-donation/{num?}', 'MissingDonation')->name('admin.missingdonation');
    });
    Route::controller(NoteController::class)->group(function(){
        Route::get('/admin/notes','GetNotes')->name('admin.notes');
        Route::post('/admin/insert-note','InsertNote')->name('admin.insertnote');
    });
    Route::controller(EventController::class)->group(function () {
        Route::get('/admin/create-event', 'CreateEvent')->name('admin.createevent');
        Route::post('/admin/insert-event', 'InsertEvent')->name('admin.insertevent');
        Route::get('/admin/event-list', 'EventList')->name('admin.eventlist');
        Route::get('/admin/edit-event/{id}', 'EditEvent')->name('admin.editevent');
        Route::post('/admin/update-event', 'UpdateEvent')->name('admin.updateevent');
        Route::get('/admin/event-details/{id?}/{recent?}', 'EventDetails')->name('admin.eventdetails');
        Route::get('/admin/get-donars/{ev_id}/{type?}', 'GetDonars')->name('admin.getdonars');
        Route::post('/admin/assign-donar-event', 'AssignEvent')->name('admin.assignevent');
        Route::get('/admin/assign-all-donar/{ev_id}/{type}', 'AssignAll')->name('admin.assignall');
        Route::get('/admin/remove-memeber/{id}', 'RemoveMember')->name('admin.removemember');
        Route::post('/admin/insert-event-note', 'InserEventNote')->name('admin.inserteventnote');
        Route::post('/admin/send-sms-all', 'SendMessageAll')->name('admin.sendsmsall');
        Route::get('/admin/select-template/{ev_id}', 'TemplateSelect')->name('admin.templateselect');
        Route::post('/admin/update-event-sms', 'UpdateEventSms')->name('admin.updateeventsms');
    });
    Route::controller(MessageTemplateController::class)->group(function(){
        Route::get('/admin/message-template','MessageTemplate')->name('admin.message_template');
        Route::post('/admin/insert-message-body','MessageBody')->name('admin.messagebody');
        Route::post('/admin/update-message-body/{id}','UpdateMessageBody')->name('admin.updatemessagebody');
    });
});
require __DIR__.'/auth.php';
