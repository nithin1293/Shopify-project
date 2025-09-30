<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Razorpay Payment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="container mt-5">
    {{-- Success flash message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Payment details OR payment form --}}
    @if (session('payment'))
        <div class="card mt-3">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Payment Details</h5>
            </div>
            <div class="card-body">
    <p><strong>Payment ID:</strong> {{ session('payment')->razorpay_payment_id }}</p>
    <p><strong>Amount:</strong> ₹{{ session('payment')->amount }}</p>

    <a href="{{ route('customerDashboard') }}" class="btn btn-warning mt-3">
        ← Back to Shopping
    </a>
</div>
        </div>
    @else
        <h2>Razorpay Payment Integration</h2>
        <form action="{{ route('razorpay.payment') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" name="phone" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="amount" class="form-label">Amount (INR)</label>
                <input type="number" id="razorpay-amount" name="amount" class="form-control" required readonly>
            </div>

            <button type="submit" class="btn btn-primary">Proceed to Pay</button>
        </form>
    @endif
</body>

</html>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const userId = localStorage.getItem('user_id');
    if (!userId) return;

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
});
</script>
