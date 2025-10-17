<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Confirmation</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #4F46E5; color: white; padding: 20px; text-align: center; }
        .content { background: #f9f9f9; padding: 20px; }
        .order-details { background: white; padding: 15px; margin: 15px 0; border-radius: 5px; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 14px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        .total { font-weight: bold; font-size: 18px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Order Confirmed!</h1>
            <p>Thank you for your purchase</p>
        </div>

        <div class="content">
            <p>Hello {{ $address->first_name }} {{ $address->last_name }},</p>
            <p>Your order has been confirmed and is being processed. Here are your order details:</p>

            <div class="order-details">
                <h3>Order #{{ $order->id }}</h3>
                <p><strong>Order Date:</strong> {{ $order->created_at->format('F d, Y') }}</p>
                <p><strong>Status:</strong> <span style="color: #10B981;">{{ ucfirst($order->status) }}</span></p>
            </div>

            <h4>Order Items:</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orderItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->unit_amount, 2) }}</td>
                        <td>${{ number_format($item->total_amount, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align: right;"><strong>Grand Total:</strong></td>
                        <td class="total">${{ number_format($order->grand_total, 2) }}</td>
                    </tr>
                </tfoot>
            </table>

            <h4>Shipping Address:</h4>
            <div class="order-details">
                <p><strong>{{ $address->first_name }} {{ $address->last_name }}</strong></p>
                <p>{{ $address->street_address }}</p>
                <p>{{ $address->city }}, {{ $address->state }} {{ $address->zip_code }}</p>
                <p>Phone: {{ $address->phone }}</p>
            </div>

            <p>We'll send you another email when your order ships. If you have any questions, please contact our support team.</p>

            <p>Best regards,<br></p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Samrach. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
