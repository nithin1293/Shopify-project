@foreach($ordersData as $order)
  <div class="order-card" style="background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: 24px; overflow: hidden; border: 1px solid #e5e7eb;">
    
    <!-- Order Header -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px 24px; color: white;">
      <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
        <div>
          <h3 style="margin: 0 0 8px 0; font-size: 20px; font-weight: 600;">{{ $order['customer_name'] }}</h3>
          <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
            <span style="background: rgba(255,255,255,0.2); padding: 6px 14px; border-radius: 20px; font-size: 13px; font-weight: 500; backdrop-filter: blur(10px);">
              {{ ucfirst($order['status']) }}
            </span>
          </div>
        </div>
        <div style="text-align: right;">
          <div style="font-size: 14px; opacity: 0.9; margin-bottom: 4px;">Order Total</div>
          <div style="font-size: 28px; font-weight: 700;">₹{{ $order['total'] }}</div>
        </div>
      </div>
    </div>

    <!-- Products Section -->
    <div style="padding: 24px;">
      <h4 style="margin: 0 0 20px 0; font-size: 16px; font-weight: 600; color: #374151; text-transform: uppercase; letter-spacing: 0.5px;">Order Items</h4>
      
      <div style="overflow-x: auto;">
        <table class="table" style="width: 100%; border-collapse: separate; border-spacing: 0;">
          <thead>
            <tr style="background: #f9fafb; border-bottom: 2px solid #e5e7eb;">
              <th style="padding: 14px 16px; text-align: left; font-weight: 600; font-size: 13px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Product</th>
              <th style="padding: 14px 16px; text-align: left; font-weight: 600; font-size: 13px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Description</th>
              <th style="padding: 14px 16px; text-align: center; font-weight: 600; font-size: 13px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Image</th>
              <th style="padding: 14px 16px; text-align: right; font-weight: 600; font-size: 13px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Price</th>
              <th style="padding: 14px 16px; text-align: center; font-weight: 600; font-size: 13px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Qty</th>
              <th style="padding: 14px 16px; text-align: right; font-weight: 600; font-size: 13px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Total</th>
            </tr>
          </thead>
          <tbody>
            @foreach($order['product_details'] as $product)
              <tr style="border-bottom: 1px solid #f3f4f6; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#f9fafb'" onmouseout="this.style.backgroundColor='transparent'">
                <td style="padding: 16px; font-weight: 500; color: #111827;">{{ $product['name'] }}</td>
                <td style="padding: 16px; color: #6b7280; font-size: 14px; max-width: 300px;">{{ $product['description'] }}</td>
                <td style="padding: 16px; text-align: center;">
                  <div style="display: inline-block; width: 80px; height: 80px; border-radius: 8px; overflow: hidden; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="w-full h-full object-cover" width="80" style="display: block;">
                  </div>
                </td>
                <td style="padding: 16px; text-align: right; color: #374151; font-weight: 500;">₹{{ $product['price'] }}</td>
                <td style="padding: 16px; text-align: center;">
                  <span style="background: #f3f4f6; padding: 6px 12px; border-radius: 6px; font-weight: 600; color: #374151; font-size: 14px;">{{ $product['quantity'] }}</span>
                </td>
                <td style="padding: 16px; text-align: right; color: #667eea; font-weight: 700; font-size: 16px;">₹{{ $product['total_price'] }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endforeach