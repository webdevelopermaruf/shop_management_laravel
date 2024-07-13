<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profit Report</title>
    
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Pushster&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Vujahday+Script&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        .Header {
            text-align: center;
            font-family: 'Roboto Condensed', sans-serif;
        }

        .Header h1 {
            font-family: 'Pushster', cursive;
            margin-bottom: 10px;

        }

        .reportheading {
            font-family: 'Roboto Condensed', sans-serif;
        }

        .price {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>

<body onload="document.title='My new title'; window.print()">

    <div class="Header">
        <h1> {{$site->site_name}} </h1>
        <i>{{$site->site_location}}</i>
        <p style='margin:8px 0px;'>Mobile: {{$site->site_phone}}</p>
    </div>
    <div style="font-family: 'Roboto Condensed', sans-serif;'">
        <div class="reportheading pl-2">

            <h1 style="text-align: center;"> Profit Report </h1>
            <hr>
            <p style='text-align:center;margin: 2px 0px;'>Profit Report From {{ $first }} to {{$last}}</p>
            <hr>
            <div class="price" style='margin:0px 10px'>
                <div>
                    <b>Factory Price: </b><i id='factoryprice'>{{$factory}}</i> BDT
                </div>
                <div>
                    <b>Sell Price: </b><i id='sellprice'>{{ $sell }}</i> BDT
                </div>
                <div>
                    <b>Profit: </b><i id='profitprice'> {!! $sell - $factory !!} </i> BDT
                </div>
            </div>
        </div>
        <br>
        <table class='table text-align' style='width:100%;'>
            <thead class='text-center'>
                <th width='5%'>OrderId</th>
                <th>Date</th>
                <th>Factory Price</th>
                <th>Sell Price</th>
                <th>Subtotal Profit</th>
            </thead>
            <tbody class='text-center'>
                @foreach ($orders as $order)
                <tr>
                    <td>{{$order->orders_id}}</td>
                    <td>{{date('d M Y', strtotime($order->orders_creation))}}</td>
                    <td>{{$order->orders_purchase_price}}</td>
                    <td>{{$order->orders_grand_price}}</td>
                    <td>{{ $order->orders_grand_price - $order->orders_purchase_price }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
</body>

</html>
