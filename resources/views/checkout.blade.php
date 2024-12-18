<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
</head>
<body>
    <h1>Checkout</h1>
    <form action="{{ route('checkout') }}" method="GET">
        <!-- Hidden input field to pass the price -->
        <input type="hidden" name="price" value="2000"> <!-- Set this to the correct price value -->
        <button type="submit">Pay with Stripe</button>
    </form>

</body>
</html>
