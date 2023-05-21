<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use PDF;

class InvoiceController extends Controller
{
    public function exportPDF($id)
    {
        $invoiceBill = Bill::find($id);

        //Hàm optional được sử dụng để tránh gọi các thuộc tính trên một đối tượng null.
        $myCourse = optional($invoiceBill->myCourse);

        $data = [
            'invoice' => $invoiceBill,
            'tenKhoaHoc' => $myCourse->tenKhoaHoc ?? 'N/A',
            'giaCa' => $myCourse->giaCa ?? 'N/A',
        ];

        return PDF::loadView('Invoices.invoice', $data)->download('hoaDon-' . $invoiceBill->maHoaDon . '.pdf');
    }

    public function revenue()
    {
        $today = Carbon::now()->toDateString();

        $revenue = DB::table('my_courses')
            ->whereDate('created_at', $today)
            ->sum('giaCa');

        return $revenue;

    }
}
