<table>
    {{$total=0}}
    @foreach($inventories as $a)
        {{$total += $a->product_purchase_price * $a->product_qty}}
    @endforeach
    <thead style="text-align::center;">
        <tr>
            <th></th>
            <th colspan="3"><h3>{{$site->site_name}}</h3></th>
            <th></th>
        </tr>
        <tr>
            <th></th>
            <th colspan="2">Total Purchase Price</th>
            <th>{{$total}}</th>
            <th></th>
        </tr>
    <tr>
        <th>Product Id</th>
        <th>Product Name</th>
        <th>Product Quantity</th>
        <th>Purchase Price</th>
        <th>Subtotal</th>
    </tr>
    </thead>
    <tbody>
    @foreach($inventories as $inventory)
        <tr>
            <td>{{ $inventory->product_id }}</td>
            <td>{{ $inventory->product_name }}</td>
            <td>{{ $inventory->product_qty }}</td>
            <td>{{ $inventory->product_purchase_price }}</td>
            <td>{{ $inventory->product_purchase_price * $inventory->product_qty }}</td>
        </tr>
    @endforeach
    </tbody>
</table>