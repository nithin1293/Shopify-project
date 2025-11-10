@foreach($ordersData as $order)
  <h3>{{ $order['customer_name'] }} - ₹{{ $order['total'] }}</h3>
  <p>Status: {{ ucfirst($order['status']) }}</p>

  <table class="table">
    <thead>
      <tr>
        <th>Product</th>
        <th>Description</th>
        <th>Image</th>
        <th>Price</th>
        <th>Qty</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      @foreach($order['product_details'] as $product)
        <tr>
          <td>{{ $product['name'] }}</td>
          <td>{{ $product['description'] }}</td>
          <td><td><img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="w-full h-full object-cover" width="80"></td>
</td>
          <td>₹{{ $product['price'] }}</td>
          <td>{{ $product['quantity'] }}</td>
          <td>₹{{ $product['total_price'] }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endforeach
