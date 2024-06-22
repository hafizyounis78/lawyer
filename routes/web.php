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


Route::get('/',  'UserController@login');//->middleware("throttle:3,2");

Auth::routes();
Route::get('home', 'HomeController@index')->name('home');
Route::get('sendsms', 'SmsController@sendScheduleSMS');
Route::group(['middleware' => ['auth']], function () {

    //notification
    Route::resource('notification', 'NotificationController');

    Route::post('home/lawsuitBar', 'HomeController@lawsuitBar');
    Route::post('home/dashboard', 'HomeController@getDashboard');
    Route::post('home/task-data', 'HomeController@taskData');
    Route::post('home/reminder-data', 'HomeController@remindersData');
    Route::post('home/session-data', 'HomeController@sessionData');
    Route::post('home/update-task-status', 'HomeController@updateTaskStatus');
   // Route::post('home/arch-data', 'HomeController@getArchdata');

    Route::resource('user', 'UserController');
    Route::get('user-data', 'UserController@userData');
    Route::post('user/availabileEmail', 'UserController@availabileEmail');
    Route::post('user/getEmployee', 'UserController@getEmployee');
    Route::post('user/delete', 'UserController@deleteUser');
    Route::post('user/activate', 'UserController@activateUser');

    //employee
    Route::resource('employee', 'EmployeeController');
    Route::get('emp-data', 'EmployeeController@empData');
    Route::post('employee/availabileEmail', 'EmployeeController@availabileEmail');
    Route::post('employee/availabileNationalId', 'EmployeeController@availabileNationalId');
    Route::post('employee/uploadFile', 'EmployeeController@uploadFile');
    Route::post('employee/file-delete', 'EmployeeController@deleteFile');
    Route::post('employee/deleteEmp', 'EmployeeController@deleteEmp');

    Route::resource('externalemp', 'ExternalController');
    Route::get('externalemp-data', 'ExternalController@empData');
    Route::post('externalemp/availabileEmail', 'ExternalController@availabileEmail');
    Route::post('externalemp/availabileNationalId', 'ExternalController@availabileNationalId');

    //roles
    Route::get('role', 'RoleController@role');
    Route::get('role-data', 'RoleController@roleData');
    Route::post('storeRole', 'RoleController@roleStore');
    Route::post('deleteRole', 'RoleController@roleDelete');
    Route::post('role/getPermissions', 'RoleController@getPermissions');
    Route::post('role/getRolePermissions', 'RoleController@getRolePermissions');

    Route::post('role/selectPer', 'RoleController@selectPer');
    Route::post('role/deselectPer', 'RoleController@deselectPer');

    Route::post('role/selectUserPer', 'RoleController@selectUserPer');
    Route::post('role/deselectUserPer', 'RoleController@deselectUserPer');
    //menu
    Route::get('menu', 'RoleController@menu');
    Route::get('menu-data', 'RoleController@menuData');
    Route::post('storeMenu', 'RoleController@menuStore');
    Route::post('deleteMenu', 'RoleController@menuDelete');

    //permission
    Route::get('permission', 'RoleController@permission');
    Route::get('permission-data', 'RoleController@permissionData');
    Route::post('storePermission', 'RoleController@permissionStore');
    Route::post('deletePermission', 'RoleController@permissionDelete');
    Route::get('role_permission', 'RoleController@role_permission');
    Route::get('user_permission', 'RoleController@user_permission');

    //setting
    Route::get('setting', 'SettingController@index');
    Route::get('setting/s1', 'SettingController@s1');
    Route::get('setting/s2', 'SettingController@s2');
    Route::get('setting/s3', 'SettingController@s3');
    Route::get('setting/s4', 'SettingController@s4');
    Route::get('setting/s5', 'SettingController@s5');
    Route::get('setting/s6', 'SettingController@s6');//rating
    Route::get('setting/s7', 'SettingController@s7');//rating
    Route::get('setting/s8', 'SettingController@s8');//rating
    Route::get('setting/s9', 'SettingController@s9');
    Route::get('setting/s10', 'SettingController@s10');//rating

    Route::get('s1-data', 'SettingController@s1_data');
    Route::get('s2-data', 'SettingController@s2_data');
    Route::get('s3-data', 'SettingController@s3_data');
    Route::get('s4-data', 'SettingController@s4_data');
    Route::get('s5-data', 'SettingController@s5_data');
    Route::get('s6-data', 'RatingController@s6_data');
    Route::get('rate-data', 'SettingController@ratesListData');//rating
    Route::get('s7-data', 'SettingController@s7_data');//rating
    Route::get('s8-data', 'SettingController@s8_data');//rating
    Route::get('s9-data', 'SettingController@s9_data');//
    Route::get('s10-data', 'SettingController@s10_data');//

    Route::post('setting/s1-save', 'SettingController@s1_save');
    Route::post('setting/s2-save', 'SettingController@s2_save');
    Route::post('setting/s1-delete', 'SettingController@s1_delete');
    Route::post('setting/s2-delete', 'SettingController@s2_delete');
    Route::post('setting/s3-save', 'SettingController@s3_save');
    Route::post('setting/s3-delete', 'SettingController@s3_delete');
    Route::post('setting/s4-save', 'SettingController@s4_save');
    Route::post('setting/s4-delete', 'SettingController@s4_delete');
    Route::post('setting/s5-save', 'SettingController@s5_save');
    Route::post('setting/s5-delete', 'SettingController@s5_delete');
    Route::post('setting/s6-save', 'SettingController@s6_save');
    Route::post('setting/s6-delete', 'SettingController@s6_delete');
    Route::post('setting/s7-save', 'SettingController@s7_save');
    Route::post('setting/s7-delete', 'SettingController@s7_delete');
    Route::post('setting/s8-save', 'SettingController@s8_save');
    Route::post('setting/s8-delete', 'SettingController@s8_delete');
    Route::post('setting/s9-save', 'SettingController@s9_save');
    Route::post('setting/s9-delete', 'SettingController@s9_delete');
    Route::post('setting/s10-save', 'SettingController@s10_save');
    Route::post('setting/s10-delete', 'SettingController@s10_delete');


});
Route::group(['middleware' => 'auth'], function () {
    Route::get('events-data', 'HomeController@eventsData');
    //users
    Route::get('logout', 'UserController@logout');
    //Route::get('user', 'UserController@index');

//External Employees
    Route::get('lawsuit-report', 'ReportController@lawsuit_report');
    Route::post('lawsuit/report', 'ReportController@lawsuitReport');
    Route::post('lawsuit/pdf','ReportController@generatePDF');

    Route::get('attendance-report', 'ReportController@attend_report');
    Route::get('task-report', 'ReportController@task_report');


    Route::post('task/report', 'ReportController@taskReport');
    Route::get('rate-report', 'ReportController@rate_report');
    Route::post('rate/report', 'ReportController@rateReport');
    //lawsuit
    Route::resource('lawsuit', 'LawsuitController');
    Route::get('edit-lawsuit', 'LawsuitController@editLawsuit');
    Route::get('show-lawsuit', 'LawsuitController@showLawsuit');
    Route::post('lawsuit/update', 'LawsuitController@update');
    Route::post('lawsuit/print', 'LawsuitController@printLawsuit');
    Route::post('lawsuit/check-File-No','LawsuitController@checkFileNo');
    Route::post('lawsuit/del-one', 'LawsuitController@del_one_lawsuit');
    Route::post('lawsuit/del-chk', 'LawsuitController@del_chk_lawsuit');

    Route::post('lawsuit-data', 'LawsuitController@lawsuitData');

    Route::post('addAgent', 'LawsuitController@storeAgent');
    Route::post('addRespondent', 'LawsuitController@storeRespondent');
    Route::post('set-id', 'LawsuitController@setSession');
    Route::post('lawsuit/uploadFile', 'LawsuitController@uploadFile');
    Route::post('lawsuit/file-delete', 'LawsuitController@deleteFile');
    Route::post('agent/get-agents-id', 'LawsuitController@get_agents_by_id');
    Route::get('agent/get-agents-name', 'LawsuitController@get_agents_by_name');
    Route::get('agent/get-agents-name1', 'LawsuitController@get_agents_by_name1');

    Route::post('agent/get-agents-names', 'LawsuitController@get_agents_names');


   // Route::get('lawsuit-agent', 'LawsuitController@lawsuitAgentData');
    Route::post('agent-delete', 'LawsuitController@deleteAgent');
    Route::post('respondent-delete', 'LawsuitController@deleteResp');

    //procedure
    Route::resource('procedure', 'ProcedureController');
   // Route::get('edit-procd', 'ProcedureController@editProcedure');
    Route::get('procedure-data', 'ProcedureController@procedureData');
  //  Route::post('proc-set-id', 'ProcedureController@setSession');

    //session
    Route::resource('session', 'SessionController');
    // Route::get('edit-procd', 'ProcedureController@editProcedure');
    Route::get('session-data', 'SessionController@sessionData');
    //  Route::post('proc-set-id', 'ProcedureController@setSession');
    //order
    Route::resource('order', 'OrderController');
    Route::get('order-data', 'OrderController@OrderData');

    //task
    Route::resource('task', 'TaskController');
    Route::get('task-data', 'TaskController@taskData');
    Route::post('task/deleteTask', 'TaskController@deleteTask');


    //attendance
    Route::resource('attendance', 'AttendanceController');
    Route::post('attendance-data', 'AttendanceController@attendanceData');
    Route::post('new-attend-data', 'AttendanceController@newAttendData');
    Route::post('attendance-change-inTime', 'AttendanceController@change_inTime');
    Route::post('attendance-change-outTime', 'AttendanceController@change_outTime');
    Route::post('attend/delete', 'AttendanceController@attend_delete');
  //  Route::get('attendance/getAttendByDate', 'AttendanceController@getAttendByDate');
    //rating
    Route::resource('rating', 'RatingController');
    Route::get('rating-data', 'RatingController@ratingData');
    Route::post('getEvalsystemRates', 'RatingController@getEvalsystemRates');
    Route::post('deselectRate', 'RatingController@deselectRate');
    Route::post('rate/getSystemRate', 'RatingController@getSystemRate');
    Route::post('rate/saveEmpRate', 'RatingController@saveEmpRate');
    Route::post('rate/confirmRate', 'RatingController@confirmRate');
    Route::post('rate/deleteRate', 'RatingController@deleteRate');




    //Reminders
    Route::resource('reminder', 'ReminderController');
    Route::get('reminder-data', 'ReminderController@remindersData');
    Route::post('reminder-delete', 'ReminderController@deleteReminder');
    Route::post('reminder-general', 'ReminderController@saveGeneral');
    Route::post('reminder-source', 'ReminderController@reminderSource');

  //  Route::get('attendance-data', 'NotificationController@notificationData');

    //messages
    Route::resource('sms', 'SmsController');
    Route::get('sms-data', 'SmsController@smsData');


    //messages
    Route::get('file/index', 'FileController@index');
    Route::get('file/file-data', 'FileController@filesData');
    Route::post('file/uploadFile', 'FileController@uploadFile');
    Route::post('file/deleteFile', 'FileController@deleteFile');
    Route::post('notification/get-noti', 'HomeController@notifications');

//agent
    Route::resource('agent-report', 'AgentController');
    Route::post('agent-data', 'AgentController@agentReport');

    //respondant
    Route::resource('respondent-report', 'RespondentController');
    Route::post('respondent-data', 'RespondentController@respondentReport');


});
