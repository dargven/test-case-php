<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Booking</title>
</head>
<body>

<h1>Order Booking</h1>

@if(session('status'))
    <p>{{ session('status') }}</p>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('order.book') }}" method="POST">
    @csrf
    <label for="event_id">Event ID:</label>
    <input type="text" name="event_id" id="event_id" required><br>

    <label for="event_date">Event Date:</label>
    <input type="date" name="event_date" id="event_date" required><br>

    <label for="ticket_adult_price">Adult Ticket Price:</label>
    <input type="number" name="ticket_adult_price" id="ticket_adult_price" required><br>

    <label for="ticket_adult_quantity">Adult Ticket Quantity:</label>
    <input type="number" name="ticket_adult_quantity" id="ticket_adult_quantity" required><br>

    <label for="ticket_kid_price">Kid Ticket Price:</label>
    <input type="number" name="ticket_kid_price" id="ticket_kid_price" required><br>

    <label for="ticket_kid_quantity">Kid Ticket Quantity:</label>
    <input type="number" name="ticket_kid_quantity" id="ticket_kid_quantity" required><br>

    <button type="submit">Book</button>
</form>

<h2>Approve Order</h2>

<form action="{{ route('order.approve') }}" method="POST">
    @csrf
    <label for="approve_barcode">Barcode:</label>
    <input type="text" name="barcode" id="approve_barcode" required><br>

    <button type="submit">Approve</button>
</form>

</body>
</html>
