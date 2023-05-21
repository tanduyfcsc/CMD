<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MyCourse;

class RevenueStatisticsController extends Controller
{
    public function RevenueStatisticsTeacher()
    {
        $courses = MyCourse::join('users', 'my_courses.giaoVienID', '=', 'users.id')
            ->where('my_courses.trangThai', 0)
            ->select('my_courses.*', 'users.hoTen as name', 'users.email', 'users.avatar', 'users.id as idGiangVien')
            ->get();
        $revenuesByTeacher = [];

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

        // Sắp xếp mảng theo doanh thu tăng dần
        usort($revenuesByTeacher, function ($a, $b) {
            return $b['value'] - $a['value'];
        });

        return $revenuesByTeacher;
    }
}
