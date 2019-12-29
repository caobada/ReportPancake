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

Route::get('cai-dat-tag','AdminController@setting_admin')->name('setting.admin');
Route::post('add_tag','AdminController@add_tag')->name('add_tag');

Route::get('del_tag','AdminController@del_tag')->name('del_tag');
Route::get('get_edit_tag','AdminController@get_edit_tag')->name('get_edit_tag');

Route::get('thong-ke-khach-hang','AdminController@report_customer')->name('report_customer.admin');

Route::post('edit_tag','AdminController@edit_tag')->name('edit_tag');

Route::get('thong-ke-khach-moi','AdminController@report_new_customer')->name('report_new_customer.admin');

Route::post('new_customer_ajax','AdminController@new_customer_ajax')->name('new_customer_ajax');

Route::get('thong-ke-duoc-si','AdminController@report_staff')->name('report_staff.admin');

Route::get('report_staff_ajax','AdminController@report_staff_ajax')->name('report_staff_ajax');

Route::get('report_customer_ajax','AdminController@report_customer_ajax')->name('report_customer_ajax');

Route::post('report_customer_ajax','AdminController@report_customer_ajax_post');

Route::get('send-messages','AdminController@send_messages')->name('send_messages.admin');

Route::post('get_count_customer_ajax','AdminController@get_count_customer_ajax');

Route::get('refresh','AdminController@refresh');