<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\BookManageController;
use App\Http\Controllers\StudentAuthController;
use App\Http\Controllers\StudentManageController;

// ─── Unified Login ───────────────────────────────────────────────────────────
Route::get('/',                              [AdminAuthController::class, 'unified_login_show']);
Route::post('/login/process',                [AdminAuthController::class, 'unified_login_process']);

// ─── Student Auth (public) ───────────────────────────────────────────────────
Route::get('/student/sign-up',               [StudentAuthController::class, 'sign_up_show']);
Route::post('/student/sign-up/process',      [StudentAuthController::class, 'sign_up_process']);
Route::post('/student/sign-in/process',      [StudentAuthController::class, 'sign_in_process']);
Route::get('/student/verify-email/{id}',     [StudentAuthController::class, 'verify_email']);
Route::post('/student/confirm-email',        [StudentAuthController::class, 'confirm_email']);
Route::get('/student/forget-password',       [StudentAuthController::class, 'forget_password']);
Route::post('/student/forget-password/process', [StudentAuthController::class, 'forget_password_process']);
Route::get('/student/recover-password/{number}', [StudentAuthController::class, 'recover_password']);
Route::post('/student/recover-password/process', [StudentAuthController::class, 'recover_password_process']);

// ─── Student Portal (authenticated) ─────────────────────────────────────────
Route::get('/student/dashboard',             [StudentAuthController::class, 'dashboard']);
Route::get('/student/log-out',               [StudentAuthController::class, 'log_out']);
Route::get('/student/change-password',       [StudentAuthController::class, 'change_password']);
Route::post('/student/change-password/process', [StudentAuthController::class, 'change_password_process']);
Route::get('/student/edit-info',             [StudentAuthController::class, 'edit_info']);
Route::post('/student/edit-info/process/{id}', [StudentAuthController::class, 'edit_info_process']);

Route::get('/student/notification',          [BookManageController::class, 'student_notification']);
Route::get('/student/notify/count',          [BookManageController::class, 'student_notify_count']);
Route::get('/student/my-collection',         [StudentManageController::class, 'my_collection']);
Route::get('/student/my-submission',         [StudentManageController::class, 'my_submission']);
Route::get('/student/borrow-history',        [StudentManageController::class, 'borrow_history']);
Route::get('/student/fines',                 [StudentManageController::class, 'my_fines']);
Route::get('/student/shelf-list',            [BookManageController::class, 'shelf_list_student']);
Route::get('/student/shelf/details/{id}',    [BookManageController::class, 'shelf_details_student']);

Route::get('/student/catalogue',                     [BookManageController::class, 'catalogue']);
Route::get('/student/borrow/{book_id}',              [BookManageController::class, 'borrow_book']);

Route::get('/student/book-list/programming',         [BookManageController::class, 'programming_book_student']);
Route::get('/student/book-list/networking',          [BookManageController::class, 'networking_book_student']);
Route::get('/student/book-list/database',            [BookManageController::class, 'database_book_student']);
Route::get('/student/book-list/electronics',         [BookManageController::class, 'electronics_book_student']);
Route::get('/student/book-list/software-development',[BookManageController::class, 'software_book_student']);
Route::get('/student/book-list/civile',              [BookManageController::class, 'civile_book_student']);

// ─── Student approval (triggered by admin links) ─────────────────────────────
Route::get('/student/approve/{id}',          [StudentManageController::class, 'student_approve']);
Route::get('/student/reject/{id}',           [StudentManageController::class, 'student_reject']);

// ─── Admin Auth ───────────────────────────────────────────────────────────────
Route::get('/admin',                         [AdminAuthController::class, 'sign_in_show']);
Route::post('/admin/sign-in/process',        [AdminAuthController::class, 'sign_in_process']);
Route::get('/admin/log-out',                 [AdminAuthController::class, 'log_out']);
Route::get('/admin/forget-password',         [AdminAuthController::class, 'forget_password']);
Route::post('/admin/forget-password/process',[AdminAuthController::class, 'forget_password_process']);
Route::get('/admin/recover-password/{number}',[AdminAuthController::class, 'recover_password']);
Route::post('/admin/recover-password/process',[AdminAuthController::class, 'recover_password_process']);

// ─── Admin Dashboard & Profile ────────────────────────────────────────────────
Route::get('/admin/dashboard',               [AdminAuthController::class, 'dashboard']);
Route::get('/admin/edit-info',               [AdminAuthController::class, 'edit_info']);
Route::post('/admin/update-info/process',    [AdminAuthController::class, 'update_info_process']);
Route::get('/admin/change-password',         [AdminAuthController::class, 'change_password']);
Route::post('/admin/change-password/process',[AdminAuthController::class, 'change_password_process']);

// ─── Admin — Students ─────────────────────────────────────────────────────────
Route::get('/admin/student-info',            [StudentManageController::class, 'student_info']);
Route::get('/admin/student/info/details/{id}',[StudentManageController::class, 'student_details']);
Route::get('/admin/student-request',         [AdminAuthController::class, 'student_request']);
Route::get('/admin/remove-student',          [StudentManageController::class, 'remove_student']);
Route::get('/admin/student/delete/process/{id}',[StudentManageController::class, 'remove_student_process']);
Route::get('/admin/notification',            [StudentManageController::class, 'notification']);
Route::get('/admin/notify/count',            [StudentManageController::class, 'notify_count']);

// ─── Admin — Books ────────────────────────────────────────────────────────────
Route::get('/admin/add-book',                [BookManageController::class, 'add_book']);
Route::post('/admin/add-book/process',       [BookManageController::class, 'add_book_process']);
Route::get('/admin/update-book',             [BookManageController::class, 'update_book']);
Route::get('/admin/book/edit/{id}',          [BookManageController::class, 'edit_book']);
Route::post('/admin/edit-book/process/{id}', [BookManageController::class, 'edit_book_process']);
Route::get('/admin/remove-book',             [BookManageController::class, 'remove_book']);
Route::get('/admin/book/delete/{id}',        [BookManageController::class, 'remove_book_process']);
Route::get('/admin/book/details/{id}',       [BookManageController::class, 'book_details']);

Route::get('/admin/programming-book',        [BookManageController::class, 'programming_book']);
Route::get('/admin/networking-book',         [BookManageController::class, 'networking_book']);
Route::get('/admin/database-book',           [BookManageController::class, 'database_book']);
Route::get('/admin/electronics-book',        [BookManageController::class, 'electronics_book']);
Route::get('/admin/software-book',           [BookManageController::class, 'software_book']);
Route::get('/admin/civile-book',             [BookManageController::class, 'civile_book']);

// ─── Admin — Orders ───────────────────────────────────────────────────────────
Route::get('/admin/fines',                   [StudentManageController::class, 'admin_fines']);
Route::get('/admin/fines/paid/{id}',         [StudentManageController::class, 'mark_fine_paid']);
Route::get('/admin/book-order',              [BookManageController::class, 'book_order']);
Route::get('/admin/add-order',               [BookManageController::class, 'add_order']);
Route::post('/admin/add-order/process',      [BookManageController::class, 'add_order_process']);
Route::get('/admin/book-received',           [BookManageController::class, 'book_received']);
Route::get('/admin/book-received/process/{id}',[BookManageController::class, 'book_received_process']);

// ─── Admin — Shelves ──────────────────────────────────────────────────────────
Route::get('/admin/shelf-list',              [BookManageController::class, 'shelf_list']);
Route::get('/admin/shelf/details/{id}',      [BookManageController::class, 'shelf_details']);
Route::get('/admin/add-shelf',               [BookManageController::class, 'add_shelf']);
Route::post('/admin/add-shelf/process',      [BookManageController::class, 'add_shelf_process']);
Route::get('/admin/update-shelf',            [BookManageController::class, 'update_shelf']);
Route::get('/admin/shelf/edit/{id}',         [BookManageController::class, 'edit_shelf']);
Route::post('/admin/edit-shelf/process/{id}',[BookManageController::class, 'edit_shelf_process']);
Route::get('/admin/remove-shelf',            [BookManageController::class, 'remove_shelf']);
Route::get('/admin/shelf/delete/{id}',       [BookManageController::class, 'remove_shelf_process']);
