<table>
    <thead>
    <tr>
        <th>Product Id</th>
        <th>Product Name</th>
        <th>Product Sold</th>
        <th>Quantity</th>
        <th>Purchase Price</th>
    </tr>
    </thead>
    <tbody>
    @foreach($stock as $item)
        <tr>
            <td>{{ $item->product_id }}</td>
            <td>{{ $item->product_name }}</td>
            <td>{{ $item->product_sold }}</td>
            <td>{{ $item->product_qty}}</td>
            <td>{{ $item->product_purchase_price }}</td>
        </tr>
    @endforeach
    </tbody>
</table>