<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Payment</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body onload="startPayment()">

    <h3 style="text-align: center">Processing Payment...</h3>

    <form name="razorpayForm" action="{{ route('razorpay.success') }}" method="POST">
        @csrf
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
        <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
        <input type="hidden" name="razorpay_signature" id="razorpay_signature">
    </form>

    <script>
        // ✅ Function to start Razorpay checkout
        function startPayment() {
            const options = {
                "key": "{{ $razorpayKey }}",
                "amount": "{{ $amount * 100 }}", // in paisa
                "currency": "INR",
                "name": "{{ $name }}",
                "description": "Order Payment",
                "order_id": "{{ $orderId }}",
                "handler": function (response) {
                    // ✅ Razorpay payment success
                    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                    document.getElementById('razorpay_order_id').value = response.razorpay_order_id;

                    // ✅ Save order details after payment success
                    saveOrderDetails().then(() => {
                        // ✅ Submit success form after saving order
                        document.forms['razorpayForm'].submit();
                    });
                },
                "prefill": {
                    "name": "{{ $name }}",
                    "email": "{{ $email }}",
                    "contact": "{{ $phone }}"
                },
                "theme": {
                    "color": "#3399cc"
                }
            };

            const rzp = new Razorpay(options);
            rzp.open();
        }

        // ✅ Function to send order data to backend API
        async function saveOrderDetails() {
            try {
                // Get user_id from localStorage
                const userId = localStorage.getItem('user_id');
                console.log("👤 User ID:", userId);
                const cartKey = 'cart_' + userId;
                const cartData = localStorage.getItem(cartKey);

                if (!cartData) {
                    console.error("No cart data found for key:", cartKey);
                    return;
                }

                // Parse cart JSON
                const productDetails = JSON.parse(cartData);

                // Prepare payload
                const payload = {
                    customer_name: "{{ $name }}",   // From Laravel backend variable
                    product_details: productDetails, // From localStorage
                    total: {{ $amount }},            // From backend
                    status: "pending",
                    user_id: userId,
                };

                console.log("🛒 Sending order data:", payload);

                // Send POST request to Laravel API
                const response = await fetch("http://127.0.0.1:8000/api/orders", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                    },
                    body: JSON.stringify(payload),
                });

                const data = await response.json();
                console.log("✅ Order saved successfully:", data);

            } catch (error) {
                console.error("❌ Failed to save order:", error);
            }
        }
    </script>

</body>
</html>
