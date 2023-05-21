<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;

class OderController extends Controller
{
    public function oderManagement()
    {
        $invoiceBills = Bill::join('my_courses', 'my_courses.id', '=', 'bills.my_course_id')
            ->orderBy('bills.id', 'DESC')
            ->paginate(2, ['bills.*', 'my_courses.tenKhoaHoc', 'my_courses.giaCa', 'my_courses.trangThai', 'my_courses.ngayMua']);
        return view('Admin.orderManagement.orderManagement', ['invoiceBills' => $invoiceBills]);

    }
}
