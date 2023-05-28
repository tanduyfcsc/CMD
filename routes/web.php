<?php

use App\Http\Controllers\Admin\AddUserController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\OderController;
use App\Http\Controllers\Admin\ResetsPasswordController;
use App\Models\MyCourse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

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

/*
Admin Dashboard
 */
Route::middleware('adminLogin')->group(function () {
    Route::get('dashboard', function () {
        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();
        $courses = MyCourse::join('users', 'my_courses.giaoVienID', '=', 'users.id')
            ->leftJoin('bills', 'my_courses.id', '=', 'bills.my_course_id')
            ->where('bills.status', 2)
            ->select('my_courses.*', 'users.hoTen as name', 'users.email', 'users.avatar', 'users.id as idGiangVien', 'bills.my_course_id')
            ->get();

        $myCourses = MyCourse::join('users', 'my_courses.giaoVienID', '=', 'users.id')
            ->leftJoin('bills', 'my_courses.id', '=', 'bills.my_course_id')
            ->where('bills.status', 2)
            ->whereBetween('my_courses.ngayMua', [$currentMonthStart, $currentMonthEnd])
            ->select('my_courses.*', 'users.hoTen as name', 'users.email', 'users.avatar', 'users.id as idGiangVien', 'bills.my_course_id')
            ->get();

        $courseMyCourseTeacher = [];
        $revenuesByTeacher = [];

        // Tính tổng doanh thu cho mỗi giáo viên dựa trên tất cả các khóa học
        foreach ($courses as $course) {
            $teacherID = $course->giaoVienID;
            if (!isset($revenuesByTeacher[$teacherID])) {
                $revenuesByTeacher[$teacherID] = [
                    'name' => $course->name,
                    'email' => $course->email,
                    'avatar' => $course->avatar,
                    'value' => 0,
                ];
            }
            $revenuesByTeacher[$teacherID]['value'] += $course->giaCa;
        }

        // Tính tổng doanh thu cho mỗi giáo viên dựa trên các khóa học đã mua trong tháng hiện tại
        foreach ($myCourses as $myCourse) {
            $teacherIDMyCourse = $myCourse->giaoVienID;
            if (!isset($courseMyCourseTeacher[$teacherIDMyCourse])) {
                $courseMyCourseTeacher[$teacherIDMyCourse] = [
                    'name' => $myCourse->name,
                    'value' => 0,
                ];
            }

            $courseMyCourseTeacher[$teacherIDMyCourse]['value'] += $myCourse->giaCa;
        }

        usort($revenuesByTeacher, function ($a, $b) {
            return $b['value'] - $a['value'];
        });

        return view('Admin.dashboard.dashboardAdmin', compact('revenuesByTeacher', 'courseMyCourseTeacher'));

    })->name('admin-dashboard');

    Route::get('user/check', [AdminLoginController::class, 'checkLogin']);

    Route::middleware('adminMiddleware')->group(function () {
        Route::get('user', function () {

            return view('Admin.user.addUser');

        })->name('admin-add-user');

        Route::get('quan-li-nhan-vien', [AddUserController::class, 'userManagement'])->name('user-management');
        Route::get('quan-li-giang-vien', [AddUserController::class, 'userLecturers'])->name('user-lecturers');

        Route::get('user/edit/{id}', [AddUserController::class, 'userEdit'])->name('user-edit');
        Route::post('user/update/{id}', [AddUserController::class, 'userUpdate'])->name('user-update');

        Route::get('user/delete/{id}', [AddUserController::class, 'userDelete'])->name('user-delete');
        Route::post('add/User', [AddUserController::class, 'addUser'])->name('add-User');
        Route::get('revenue/statistics/teacher', [RevenueStatisticsController::class, 'RevenueStatisticsTeacher'])->name('RevenueStatisticsTeacher');

        Route::get('delete/{id}/order', [OderController::class, 'orderDelete'])->name('order-Delete');

    });
    Route::post('update/{id}/student', [AddUserController::class, 'studentUpdate'])->middleware('studentManagement')->name('studentUpdate');

    Route::get('view/{id}/student', [AddUserController::class, 'studentEdit'])->middleware('studentManagement')->name('studentEdit');

    Route::get('delete/{id}/student', [AddUserController::class, 'studentDelete'])->middleware('studentManagement')->name('studentDelete');

    Route::get('quan-li-nguoi-dung', [AddUserController::class, 'studentManagement'])->middleware('studentManagement')->name('studentManagement');

    Route::get('quan-li-don-hang', [OderController::class, 'oderManagement'])->name('oder-management');
    Route::post('update/{id}/order', [OderController::class, 'orderUpdate'])->name('orderUpdate');
    Route::get('logout', [AdminLoginController::class, 'logout'])->name('logout-admin');

});

Route::get('resets/password/admin', [ResetsPasswordController::class, 'viewResetPassword'])->name('viewResetPassword');
Route::post('post/resets/password', [ResetsPasswordController::class, 'postResetPassword'])->name('postResetPassword');

/*
Login Admin
 */
Route::get('/login', [AdminLoginController::class, 'loginForm'])->name('admin-login');
Route::post('/login', [AdminLoginController::class, 'login']);
