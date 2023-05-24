<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use Illuminate\Http\Request;

class OderController extends Controller
{
    public function oderManagement()
    {
        $invoiceBills = Bill::join('my_courses', 'my_courses.id', '=', 'bills.my_course_id')
            ->orderBy('bills.id', 'DESC')
            ->paginate(5, ['bills.*', 'my_courses.tenKhoaHoc', 'my_courses.giaCa', 'my_courses.trangThai', 'my_courses.ngayMua', 'my_courses.linkVideo']);

        return view('Admin.orderManagement.orderManagement', ['invoiceBills' => $invoiceBills]);

    }

    public function orderDelete($id)
    {

        Bill::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Xóa hóa đơn thành công');

    }

    public function orderUpdate(Request $request, $id)
    {
        $data = [
            'status' => $request->status,
        ];

        Bill::where('id', $id)->update($data);

        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công');

    }
}
