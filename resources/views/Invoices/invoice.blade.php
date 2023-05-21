<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fabcart</title>
    <style>
        body {
            background-color: #F6F6F6;
            margin: 0;
            padding: 0;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin: 0;
            padding: 0;
        }

        p {
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin-right: auto;
            margin-left: auto;
        }

        .brand-section {
            background-color: #0d1033;
            padding: 10px 40px;
        }

        .logo {
            width: 50%;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .col-6 {
            width: 50%;
            flex: 0 0 auto;
        }

        .text-white {
            color: #fff;
        }

        .company-details {
            float: right;
            text-align: right;
        }

        .body-section {
            padding: 16px;
            border: 1px solid gray;
        }

        .heading {
            font-size: 20px;
            margin-bottom: 08px;
        }

        .sub-heading {
            color: #262626;
            margin-bottom: 05px;
        }

        table {
            background-color: #fff;
            width: 100%;
            border-collapse: collapse;
        }

        table thead tr {
            border: 1px solid #111;
            background-color: #f2f2f2;
        }

        table td {
            vertical-align: middle !important;
            text-align: center;
        }

        table th,
        table td {
            padding-top: 08px;
            padding-bottom: 08px;
        }

        .table-bordered {
            box-shadow: 0px 0px 5px 0.5px gray;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #dee2e6;
        }

        .text-right {
            text-align: end;
        }

        .w-20 {
            width: 20%;
        }

        .float-right {
            float: right;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="brand-section">
            <div class="row">
                <div class="col-12" style="text-align: center">
                    <h1 class="text-white"><img src="https://hocmai.vn/assets/front/images/logo.png" alt="">
                    </h1>
                </div>
            </div>
        </div>

        <div class="body-section">
            <div class="row">
                <div class="col-6">
                    <h2 class="heading" style="font-family: DejaVu Sans;font-size: 13px">Mã hóa đơn:
                        {{ $invoice->maHoaDon }}</h2>
                    <p class="sub-heading" style="font-family: DejaVu Sans;font-size: 13px">Mã kích hoạt:
                        {{ $invoice->maKichHoat }}
                    </p>
                    <p class="sub-heading" style="font-family: DejaVu Sans;font-size: 13px">Ngày mua:
                        {{ $invoice->created_at->format('d/m/Y') }} </p>
                </div>
                <div class="col-6">
                    <p class="sub-heading" style="font-family: DejaVu Sans;font-size: 13px">Họ và tên:
                        {{ $invoice->hoTen }} </p>
                    <p class="sub-heading" style="font-family: DejaVu Sans;font-size: 13px">Địa chỉ:
                        {{ $invoice->diaChi }}
                    </p>
                    <p class="sub-heading" style="font-family: DejaVu Sans;font-size: 13px">Số điện thoại:
                        {{ $invoice->soDienThoai }}
                    </p>
                </div>
            </div>
        </div>

        <div class="body-section">
            <h3 class="heading" style="font-family: DejaVu Sans;font-size: 15px">Khóa học đã mua</h3>
            <br>
            <table class="table-bordered">
                <thead>
                    <tr>
                        <th style="font-family: DejaVu Sans;font-size: 13px">Tên khóa học</th>
                        <th class="w-20" style="font-family: DejaVu Sans;font-size: 13px">Giá khóa học</th>
                        <th class="w-20"style="font-family: DejaVu Sans;font-size: 13px">Số lượng</th>
                        <th class="w-20" style="font-family: DejaVu Sans;font-size: 13px">Tổng cộng</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-family: DejaVu Sans;font-size: 13px">{{ $tenKhoaHoc }}</td>
                        <td style="font-family: DejaVu Sans;font-size: 13px">
                            {{ number_format(floatval($giaCa), 0, ',', '.') }}VNĐ</td>
                        <td style="font-family: DejaVu Sans;font-size: 13px">1</td>
                        <td style="font-family: DejaVu Sans;font-size: 13px">
                            {{ number_format(floatval($giaCa), 0, ',', '.') }}VNĐ</td>

                    </tr>
                    <tr>
                        <td colspan="3" class="text-right" style="font-family: DejaVu Sans;font-size: 13px">Phí vẫn
                            chuyển</td>
                        <td style="font-family: DejaVu Sans;font-size: 13px">FREE</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right"style="font-family: DejaVu Sans;font-size: 13px">Tổng cộng
                        </td>
                        <td style="font-family: DejaVu Sans;font-size: 13px">
                            {{ number_format(floatval($giaCa), 0, ',', '.') }}VNĐ</td>
                    </tr>
                </tbody>
            </table>
            <br>
        </div>
    </div>

</body>

</html>
