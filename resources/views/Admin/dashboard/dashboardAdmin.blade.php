@extends('Admin.master')
@section('content')
    <!-- [ Layout content ] Start -->
    <div class="layout-content">

        <!-- [ content ] Start -->
        <div class="container-fluid flex-grow-1 container-p-y">
            <div class="row">
                <!-- 1st row Start -->
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="">
                                            <h2 class="mb-2"> {{ $revenue }} </h2>
                                            <p class="text-muted mb-0"><span class="badge badge-primary"
                                                    style="background-color: #eec915 !important">Tổng số đơn
                                                    hàng hôm nay</span></p>
                                        </div>
                                        <div class="lnr lnr-leaf display-4 text-primary"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="">
                                            <h2 class="mb-2">{{ number_format(floatval($revenueMonth), 0, ',', '.') }} VNĐ
                                            </h2>

                                            <div class="customer" style="display:flex">
                                                <p class="text-muted mb-0">
                                                    @if ($percentage > 0)
                                                        <i class="ion ion-md-arrow-round-up ml-3 text-success"
                                                            style=" margin-left: 0 !important; margin-right: 2px; "></i>
                                                    @else
                                                        <i class="ion ion-md-arrow-round-down ml-3 text-danger"
                                                            style=" margin-left: 0 !important; margin-right: 2px; "></i>
                                                    @endif
                                                    {{ number_format($percentage, 2) }}%
                                                <p class="text-muted mb-0"><span class="badge badge-primary"
                                                        style=" margin-left: 5px; ">Tổng số doanh thu tháng này</span>
                                                </p>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="lnr lnr-chart-bars display-4 text-success"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card d-flex w-100 mb-4">
                                <div class="row no-gutters row-bordered row-border-light h-100">
                                    <div class="d-flex col-md-6 align-items-center">
                                        <div class="card-body">
                                            <div class="row align-items-center mb-3">
                                                <div class="col-auto">
                                                    <i class="lnr lnr-users text-primary display-4"></i>
                                                </div>
                                                <div class="col">
                                                    <h4 class="mt-3 mb-0">{{ $totalUsersMonth }}
                                                        @if ($percentageUser > 0)
                                                            <i class="ion ion-md-arrow-round-up ml-3 text-success"></i>
                                                        @elseif ($percentageUser < 0)
                                                            <i class="ion ion-md-arrow-round-down ml-3 text-danger"></i>
                                                        @endif
                                                    </h4>
                                                </div>
                                            </div>
                                            <div class="customer" style="display:flex">
                                                <p class="mb-0 text-muted">{{ $percentageUser }}%
                                                <p class="text-muted mb-0"><span class="badge badge-primary"
                                                        style="background-color: #2f58ba !important;margin-left: 5px; ">
                                                        Tổng số người dùng đăng kí tháng này
                                                    </span>
                                                </p>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="card-header with-elements">
                            <h6 class="card-header-title mb-0">Thống kê doanh thu giảng viên</h6>
                            <div class="card-header-elements ml-auto">

                            </div>
                        </div>
                        <div class="card-body">
                            <style>
                                #chartdiv {
                                    width: 100%;
                                    height: 500px;
                                }
                            </style>

                            <!-- Resources -->
                            <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
                            <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
                            <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

                            <!-- Chart code -->
                            <script>
                                am5.ready(function() {

                                    var root = am5.Root.new("chartdiv");


                                    root.setThemes([
                                        am5themes_Animated.new(root)
                                    ]);


                                    var chart = root.container.children.push(am5xy.XYChart.new(root, {
                                        panX: false,
                                        panY: false,
                                        wheelX: "none",
                                        wheelY: "none"
                                    }));


                                    var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
                                    cursor.lineY.set("visible", false);


                                    var xRenderer = am5xy.AxisRendererX.new(root, {
                                        minGridDistance: 30
                                    });

                                    var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
                                        maxDeviation: 0,
                                        categoryField: "name",
                                        renderer: xRenderer,
                                        tooltip: am5.Tooltip.new(root, {})
                                    }));

                                    xRenderer.grid.template.set("visible", false);

                                    var yRenderer = am5xy.AxisRendererY.new(root, {});
                                    var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                                        maxDeviation: 0,
                                        min: 0,
                                        extraMax: 0.1,
                                        renderer: yRenderer
                                    }));

                                    yRenderer.grid.template.setAll({
                                        strokeDasharray: [2, 2]
                                    });


                                    var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                                        name: "Series 1",
                                        xAxis: xAxis,
                                        yAxis: yAxis,
                                        valueYField: "value",
                                        sequencedInterpolation: true,
                                        categoryXField: "name",
                                        tooltip: am5.Tooltip.new(root, {
                                            dy: -25,
                                            labelText: "{valueY}"
                                        })
                                    }));


                                    series.columns.template.setAll({
                                        cornerRadiusTL: 5,
                                        cornerRadiusTR: 5,
                                        strokeOpacity: 0
                                    });

                                    series.columns.template.adapters.add("fill", (fill, target) => {
                                        return chart.get("colors").getIndex(series.columns.indexOf(target));
                                    });

                                    series.columns.template.adapters.add("stroke", (stroke, target) => {
                                        return chart.get("colors").getIndex(series.columns.indexOf(target));
                                    });

                                    var data = [
                                        @foreach ($revenuesByTeacher as $revenue)

                                            @if (isset($revenue['name']) && isset($revenue['value']))
                                                {
                                                    "name": "{{ $revenue['name'] }}",

                                                    "value": {{ $revenue['value'] }},
                                                    bulletSettings: {
                                                        src: "https://www.amcharts.com/lib/images/faces/D02.png"
                                                    }
                                                },
                                            @endif
                                        @endforeach
                                    ];

                                    console.log(data);
                                    series.data.setAll(data);

                                    series.bullets.push(function() {
                                        return am5.Bullet.new(root, {
                                            locationY: 1,
                                            sprite: am5.Picture.new(root, {
                                                templateField: "bulletSettings",
                                                width: 40,
                                                height: 40,
                                                centerX: am5.p50,
                                                centerY: am5.p50,
                                                shadowColor: am5.color(0x000000),
                                                shadowBlur: 4,
                                                shadowOffsetX: 4,
                                                shadowOffsetY: 4,
                                                shadowOpacity: 0.6
                                            })
                                        });
                                    });

                                    xAxis.data.setAll(data);
                                    series.data.setAll(data);


                                    series.appear(1000);
                                    chart.appear(1000, 100);

                                });
                            </script>

                            <div id="chartdiv"></div>


                            <script src="https://code.highcharts.com/highcharts.js"></script>
                            <script src="https://code.highcharts.com/modules/exporting.js"></script>
                            <script src="https://code.highcharts.com/modules/export-data.js"></script>
                            <script src="https://code.highcharts.com/modules/accessibility.js"></script>

                            <style>
                                .highcharts-figure,
                                .highcharts-data-table table {
                                    min-width: 320px;
                                    max-width: 800px;
                                    margin: 1em auto;
                                }

                                .highcharts-data-table table {
                                    font-family: Verdana, sans-serif;
                                    border-collapse: collapse;
                                    border: 1px solid #ebebeb;
                                    margin: 10px auto;
                                    text-align: center;
                                    width: 100%;
                                    max-width: 500px;
                                }

                                .highcharts-data-table caption {
                                    padding: 1em 0;
                                    font-size: 1.2em;
                                    color: #555;
                                }

                                .highcharts-data-table th {
                                    font-weight: 600;
                                    padding: 0.5em;
                                }

                                .highcharts-data-table td,
                                .highcharts-data-table th,
                                .highcharts-data-table caption {
                                    padding: 0.5em;
                                }

                                .highcharts-data-table thead tr,
                                .highcharts-data-table tr:nth-child(even) {
                                    background: #f8f8f8;
                                }

                                .highcharts-data-table tr:hover {
                                    background: #f1f7ff;
                                }

                                input[type="number"] {
                                    min-width: 50px;
                                }
                            </style>
                            <figure class="highcharts-figure" style=" margin-top: 60px;">
                                <div id="container"></div>
                            </figure>

                            <script>
                                var currentDate = new Date();
                                var currentMonth = currentDate.getMonth() + 1;
                                var titleText = 'Phần trăm doanh thu từng giáo viên - Tháng ' + currentMonth;
                                Highcharts.chart('container', {
                                    chart: {
                                        plotBackgroundColor: null,
                                        plotBorderWidth: null,
                                        plotShadow: false,
                                        type: 'pie'
                                    },
                                    title: {
                                        text: titleText,
                                        align: 'left'
                                    },
                                    tooltip: {
                                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                                    },
                                    accessibility: {
                                        point: {
                                            valueSuffix: '%'
                                        }
                                    },
                                    plotOptions: {
                                        pie: {
                                            allowPointSelect: true,
                                            cursor: 'pointer',
                                            dataLabels: {
                                                enabled: true,
                                                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                                            }
                                        }
                                    },
                                    series: [{
                                        name: 'Phần trăm',
                                        colorByPoint: true,
                                        data: [
                                            @foreach ($courseMyCourseTeacher as $courseMyCourse)

                                                @if (isset($courseMyCourse['name']) && isset($courseMyCourse['value']))
                                                    {
                                                        "name": "{{ $courseMyCourse['name'] }}",

                                                        "y": {{ $courseMyCourse['value'] }},

                                                    },
                                                @endif
                                            @endforeach
                                        ]
                                    }]



                                });
                            </script>
                        </div>
                    </div>
                </div>
                <!-- 1st row Start -->
            </div>
        </div>
        <!-- [ content ] End -->
    </div>
    <!-- [ Layout content ] Start -->
@endsection
