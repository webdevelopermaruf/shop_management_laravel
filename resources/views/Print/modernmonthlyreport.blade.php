<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Monthly Report</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <style type="text/css">
        body {
            font-family: IBM Plex Sans;
            font-size: 12px;
            padding-top: 15px;
        }

        #SellCharts,
        #expenseCharts {
            width: 350px !important;
            height: 350px !important;
            padding-left: 40px;
            padding-top: 40px;
        }

        .titleTagReport {
            text-align: center;
            font-size: 18px;
            margin: auto;
            color: red;
        }

        .flex_box {
            display: flex;
        }

        .flex_box .col-6 {
            width: 50%;
        }


        .boxshape {
            width: 40px;
            height: 40px;
            /* background: red; */
            margin-right: 10px;
        }

        .SellsInfo>.flex_box {
            padding-bottom: 30px;
        }

        .bg-success {
            background: green;
        }

        .bg-danger {
            background: #ff6384;
        }

        .bg-info {
            background: #36a2eb;
        }

        .bg-darkblue {
            background: #023047;
            
        }
        .bg-lightblue {
            background: #8ecae6;
        }

        .bg-warning {
            background: #ff5733;

        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

{{-- <body onload="window.print();"> --}}

<body>
    <div class="container">
        <div class="text-center text-primary">
            <h2 style="margin-top:0px">{{ $site->site_name }}</h2>
            <p>{{ $site->site_location }}</p>
            <p>{{ $site->site_phone }}</p>
        </div>
        <hr>
        <div class="sellsChartBox">
            <div class="titleTagReport">
                Sell Analysis of {{ date('F Y', strtotime($month)) }}</div>
            <div class="flex_box">
                <div class="col-6"> <canvas id="SellCharts"></canvas> </div>
                <div class="col-6">
                    <div class="SellsInfo" style="margin: 100px 0px 0 0;">
                        <div class="info1 flex_box">
                            <div class="boxshape bg-success"></div>
                            <h4>Total Sold Price: {{ $sell }} BDT.</h4>
                        </div>
                        <div class="info2 flex_box">
                            <div class="boxshape bg-danger"></div>
                            <h4>Total Purchase Price: {{ $purchase }} BDT.</h4>
                        </div>
                        <div class="info3 flex_box">
                            <div class="boxshape bg-info"></div>
                            <h4>Total Profit: {{ $profit = $sell - $purchase }} BDT.</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br><br><br>
        <div class="sellsChartBox">
            <div class="titleTagReport">
                Expenses & Profit Analysis of {{ date('F Y', strtotime($month)) }}</div>
            <div class="flex_box">
                <div class="col-6">
                    <div class="SellsInfo" style="margin: 100px 0px 0 0;">
                        <div class="info4 flex_box">
                            <div class="boxshape bg-darkblue"></div>
                            <h4>Total Returned Price: {{ $return }} BDT.</h4>
                        </div>
                        <div class="info5 flex_box">
                            <div class="boxshape bg-lightblue"></div>
                            <h4>Total Expense Price: {{ $expense }} BDT.</h4>
                        </div>
                        <div class="info6 flex_box">
                            <div class="boxshape bg-warning"></div>
                            <h4>Total Actual Profit: {{ $actual = $profit - ($return + $expense) }} BDT.</h4>
                        </div>
                    </div>
                </div>
                <div class="col-6"> <canvas id="expenseCharts"></canvas> </div>
            </div>
        </div>
        <br><br><br>    
        <h3 class="text-center"> Actual Profit = {{ $actual }} </h3>
        <div class="text-center">
            <div class="no-print">
                <div>
                    <button type="button" id="" class="btn btn-lg btn-success" onclick="window.print();"
                        title="Print">Print</button>
                </div>
            </div>

        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('SellCharts');
    const ctx2 = document.getElementById('expenseCharts');
    const data = {
        labels: [
            'Purchase',
            'Profit'
        ],
        datasets: [{
            data: [{{ $purchase }}, {{ $profit }}],
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)'
            ],
            borderColor: "#999",
            hoverOffset: 10
        }]
    };
    const actual_profit = {{ $profit }} - ({{ $expense }} + {{ $return }});
    const data2 = {
        labels: [
            'Expenses',
            'Return Product',
            'Actual Profit',
        ],
        datasets: [{
            data: [{{ $expense }}, {{ $return }}, actual_profit],
            backgroundColor: [
                '#8ecae6',
                '#023047',
                '#ff5733',
            ],
            borderColor: "#999",
            hoverOffset: 10
        }]
    };
    new Chart(ctx, {
        type: 'doughnut',
        data: data,
    });
    new Chart(ctx2, {
        type: 'pie',
        data: data2,
    });
</script>

</html>
