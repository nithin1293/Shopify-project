<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Checkout - Razorpay</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #5469d4;
            --secondary-color: #0a2540;
            --success-color: #00d4aa;
            --background-light: #f6f9fc;
            --border-color: #e3e8ee;
            --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.04);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            padding: 2rem 0;
        }

        .checkout-container {
            max-width: 600px;
            margin: 0 auto;
        }

        .page-header {
            text-align: center;
            color: white;
            margin-bottom: 2rem;
        }

        .page-header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .page-header p {
            font-size: 1rem;
            opacity: 0.9;
        }

        .checkout-card {
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            margin-bottom: 1.5rem;
            border: none;
            transition: transform 0.3s ease;
        }

        .checkout-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
        }

        .card-header-custom {
            background: linear-gradient(135deg, var(--primary-color) 0%, #4355c9 100%);
            color: white;
            padding: 1.5rem;
            border: none;
        }

        .card-header-custom.success {
            background: linear-gradient(135deg, #00d4aa 0%, #00b894 100%);
        }

        .card-header-custom h5 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-body-custom {
            padding: 2rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            border: 2px solid var(--border-color);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: var(--background-light);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(84, 105, 212, 0.1);
            background-color: white;
        }

        .form-control:disabled,
        .form-control[readonly] {
            background-color: #f0f3f7;
            cursor: not-allowed;
        }

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #8898aa;
            z-index: 10;
        }

        .form-control.with-icon {
            padding-left: 3rem;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-color) 0%, #4355c9 100%);
            border: none;
            padding: 1rem 2rem;
            font-size: 1.125rem;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(84, 105, 212, 0.3);
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(84, 105, 212, 0.4);
            background: linear-gradient(135deg, #4355c9 0%, var(--primary-color) 100%);
        }

        .btn-back {
            background: white;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-back:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(84, 105, 212, 0.3);
        }

        .alert-custom {
            border-radius: 12px;
            border: none;
            padding: 1.25rem 1.5rem;
            box-shadow: var(--shadow-md);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .alert-custom i {
            font-size: 1.5rem;
        }

        .alert-success-custom {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: #6c757d;
            font-weight: 500;
        }

        .detail-value {
            color: var(--secondary-color);
            font-weight: 600;
        }

        .amount-highlight {
            font-size: 1.5rem;
            color: var(--primary-color);
        }

        .address-card-custom {
            background: var(--background-light);
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 1rem;
            border: 2px solid var(--border-color);
        }

        .address-card-custom h6 {
            color: var(--secondary-color);
            font-weight: 700;
            margin-bottom: 0.75rem;
            font-size: 1.125rem;
        }

        .address-card-custom p {
            color: #525f7f;
            line-height: 1.6;
            margin-bottom: 0;
        }

        .security-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem;
            background: var(--background-light);
            border-radius: 8px;
            margin-top: 1.5rem;
            color: #6c757d;
            font-size: 0.875rem;
        }

        .security-badge i {
            color: var(--success-color);
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem 0;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }

            .card-body-custom {
                padding: 1.5rem;
            }

            .btn-primary-custom {
                font-size: 1rem;
                padding: 0.875rem 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="container checkout-container">
        <div class="page-header">
            <h1><i class="fas fa-lock"></i> Secure Checkout</h1>
            <p>Complete your purchase safely with Razorpay</p>
        </div>

        {{-- Success flash message --}}
        @if (session('success'))
            <div class="alert-custom alert-success-custom" role="alert">
                <i class="fas fa-check-circle"></i>
                <div>
                    <strong>Success!</strong> {{ session('success') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Payment details OR payment form --}}
        @if (session('payment'))
            {{-- UPDATED: Get payment object and show address card --}}
            @php
                $payment = session('payment');
            @endphp

            <div class="checkout-card">
                <div class="card-header-custom success">
                    <h5><i class="fas fa-check-circle"></i> Payment Successful</h5>
                </div>
                <div class="card-body-custom">
                    <div class="detail-row">
                        <span class="detail-label"><i class="fas fa-receipt"></i> Payment ID</span>
                        <span class="detail-value">{{ $payment->razorpay_payment_id }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label"><i class="fas fa-rupee-sign"></i> Amount Paid</span>
                        <span class="detail-value amount-highlight">₹{{ number_format($payment->amount, 2) }}</span>
                    </div>
                </div>
            </div>

            {{-- NEW: Show Shipping Address Card --}}
            @if ($payment->address)
                <div class="checkout-card">
                    <div class="card-header-custom">
                        <h5><i class="fas fa-shipping-fast"></i> Shipping Information</h5>
                    </div>
                    <div class="card-body-custom">
                        <div class="address-card-custom">
                            <h6><i class="fas fa-user"></i> {{ $payment->address->name }}</h6>
                            <p>
                                <i class="fas fa-map-marker-alt"></i> 
                                {{ $payment->address->flat_no }}, {{ $payment->address->street }}<br>
                                {{-- Use a standard if block for Blade --}}
                                @if($payment->address->landmark)
                                    Near {{ $payment->address->landmark }}<br>
                                @endif
                                {{ $payment->address->town }}, {{ $payment->address->state }} - {{ $payment->address->pincode }}
                            </p>
                            <p style="margin-top: 0.75rem;">
                                <i class="fas fa-phone"></i> <strong>{{ $payment->address->mobile_number }}</strong>
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="text-center">
                <a href="{{ route('customerDashboard') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Continue Shopping
                </a>
            </div>
        @else
            <div class="checkout-card">
                <div class="card-header-custom">
                    <h5><i class="fas fa-credit-card"></i> Payment Information</h5>
                </div>
                <div class="card-body-custom">
                    <form action="{{ route('razorpay.payment') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="form-label"><i class="fas fa-user"></i> Full Name</label>
                            <div class="input-group">
                                <input type="text" name="name" class="form-control" placeholder="Enter your full name" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label"><i class="fas fa-envelope"></i> Email Address</label>
                            <div class="input-group">
                                <input type="email" name="email" class="form-control" placeholder="your.email@example.com" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="phone" class="form-label"><i class="fas fa-phone"></i> Phone Number</label>
                            <div class="input-group">
                                <input type="text" name="phone" class="form-control" placeholder="+91 XXXXX XXXXX" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="amount" class="form-label"><i class="fas fa-rupee-sign"></i> Amount (INR)</label>
                            <div class="input-group">
                                <input type="number" id="razorpay-amount" name="amount" class="form-control" required readonly>
                            </div>
                        </div>
                        
                        {{-- NEW: Add hidden field for address_id --}}
                        <input type="hidden" name="address_id" id="address_id">

                        <button type="submit" class="btn-primary-custom">
                            <i class="fas fa-shield-alt"></i> Proceed to Secure Payment
                        </button>

                        <div class="security-badge">
                            <i class="fas fa-lock"></i>
                            <span>Your payment information is encrypted and secure</span>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center" style="margin-top: 1.5rem;">
                <img src="https://razorpay.com/assets/razorpay-glyph.svg" alt="Razorpay" style="height: 24px; opacity: 0.7;">
                <p style="color: white; margin-top: 0.5rem; font-size: 0.875rem; opacity: 0.9;">
                    Powered by Razorpay - Trusted by millions
                </p>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const userId = localStorage.getItem('user_id');
    if (!userId) return;

    // --- Set Cart Total ---
    const cartKey = 'cart_' + userId;
    let cart = JSON.parse(localStorage.getItem(cartKey)) || [];

    let totalPrice = 0;
    cart.forEach(item => {
        totalPrice += item.price * item.quantity;
    });

    let amountInput = document.getElementById("razorpay-amount");
    if (amountInput) {
        amountInput.value = totalPrice;
    }

    // --- NEW: Set Selected Address ID ---
    const selectedAddressId = localStorage.getItem('selected_address_id');
    let addressInput = document.getElementById('address_id');
    if (addressInput && selectedAddressId) {
        addressInput.value = selectedAddressId;
    } else if (addressInput) {
        // Handle case where no address is selected
        console.error('No address ID found in localStorage.');
        alert('Please select a shipping address before proceeding.');
        // Optionally redirect back to cart
        // window.location.href = "{{ route('cart') }}";
    }
});
</script>