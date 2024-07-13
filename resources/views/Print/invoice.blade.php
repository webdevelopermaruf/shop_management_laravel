<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sales Invoice</title>
    <style type="text/css">
        body {
            font-family: arial;
            font-size: 12px;
            padding-top: 0px;
        }

        tbody {
            border: 0.1px dashed black;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print();">
    <table width="98%" align="center">
        <tr>
            <td align="center">
                <span>
                    <strong>{{ $site->site_name }}</strong><br>
                    {{ $site->site_location }}<br>
                    {{ $site->site_phone }}<br>
                </span>
            </td>
        </tr>
        <tr>
            <td align="center"><strong>-----------------Invoice-----------------</strong></td>
        </tr>
        <tr>
            <td>
                <table width="100%">
                    <tr>
                        <td width="40%">Invoice</td>
                        <td><b>#SL{{ $orders->orders_id }}</b></td>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td>
                            @if ($orders->orders_holder == 'guest')
                                Walk-in Customer
                            @else
                                {{ $orders->orders_holder }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Mobile</td>
                        <td>
                            @if ($orders->orders_holder_phone == 'guest')
                            @else
                                {{ $orders->orders_holder_phone }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Date: {{ date('d-M-Y', strtotime($orders->orders_creation)) }}</td>
                        <td style="text-align: right;">Time: {{ date('g:i a', strtotime($orders->orders_creation)) }}
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr style="border-top-style: dashed;border-bottom-style: dashed;border-width: 0.1px;">
                            <th style="font-size: 11px; text-align: left;padding-left: 2px; padding-right: 2px;">#</th>
                            <th style="font-size: 11px; text-align: left;padding-left: 2px; padding-right: 2px;">
                                Description</th>
                            <th style="font-size: 11px; text-align: left;padding-left: 2px; padding-right: 2px;">Price
                            </th>
                            <th style="font-size: 11px; text-align: center;padding-left: 2px; padding-right: 2px;">
                                Quantity</th>
                            <th style="font-size: 11px; text-align: right;padding-left: 2px; padding-right: 2px;">
                                Discount</th>
                            <th style="font-size: 11px; text-align: right;padding-left: 2px; padding-right: 2px;">Total
                            </th>
                        </tr>
                    </thead>
                    <tbody style="border-bottom-style: dashed;border-width: 0.1px;">
                        @foreach ($items as $item)
                            <tr>
                                <td style='padding-left: 2px; padding-right: 2px;' valign='top'>{{ $loop->iteration }}
                                </td>
                                <td style='padding-left: 2px; padding-right: 2px;'>{{ $item->invoice_product }}</td>
                                <td style='padding-left: 2px; padding-right: 2px;'>{{ $item->invoice_sell }}</td>
                                <td style='text-align: center;padding-left: 2px; padding-right: 2px;'>
                                    {{ $item->invoice_qty }}</td>
                                <td style='text-align: right;padding-left: 2px; padding-right: 2px;'>
                                    {{ $item->invoice_discount }}</td>
                                <td style='text-align: right;padding-left: 2px; padding-right: 2px;'>
                                    {{ $item->invoice_paid }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot style="padding-bottom:40px">
                        <tr>
                            <td style=" padding-left: 2px; padding-right: 2px;" colspan="5" align="right">Other
                                Charges</td>
                            <td style=" padding-left: 2px; padding-right: 2px;" align="right">0</td>
                        </tr>
                        <tr>
                            <td style=" padding-left: 2px; padding-right: 2px;font-weight: bold;" colspan="5"
                                align="right">Total</td>
                            <td style=" padding-left: 2px; padding-right: 2px;font-weight: bold;" align="right">
                                {{ $orders->orders_sell_price }}
                            </td>
                        </tr>

                        <tr>
                            <td style=" padding-left: 2px; padding-right: 2px;" colspan="5"
                                align="right">Total Discount</td>
                            <td style=" padding-left: 2px; padding-right: 2px;" align="right">
                                {{ $orders->orders_discount_price }}
                            </td>
                        </tr>
                        <tr>
                            <td style=" padding-left: 2px; padding-right: 2px; font-weight: bold;" colspan="5" align="right">Paid
                                Payment</td>
                            <td style=" padding-left: 2px; padding-right: 2px; font-weight: bold;" align="right">
                                {{ $orders->orders_grand_price }}</td>
                        </tr>
                        <tr>
                            <td style=" padding-left: 2px; padding-right: 2px;" colspan="5" align="right">Change
                                Return</td>
                            <td style=" padding-left: 2px; padding-right: 2px;" align="right">0</td>
                        </tr>
                        <tr>
                            <td colspan="6" align="center"> পণ্য ফেরত দেয়ার ক্ষেত্রে টাকা ফেরত দেয়া হয় না।  </td>
                        </tr>
                        <tr>
                            <td colspan="6" align="center">  ২ দিনের বেশি হলে পণ্য গ্রহনযোগ্য নয়। </td>
                        </tr>
                        <tr>
                            <td colspan="6" align="center">----------Thanks You. Visit Again!----------</td>
                        </tr>
                    </tfoot>
                </table>
            </td>
        </tr>
    </table>
    <center>
        <div class="row no-print">
            <div class="col-md-12">
                <div class="col-md-2 col-md-offset-5 col-xs-4 col-xs-offset-4 form-group">
                    <button type="button" id="" class="btn btn-block btn-success btn-xs"
                        onclick="window.print();" title="Print">Print</button>
                </div>
            </div>
        </div>

    </center>
</body>

</html>
