<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fa;
            padding: 40px;
        }

        .invoice-container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }

        .invoice-title {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }

        .thank-you {
            font-size: 18px;
            font-weight: bold;
            color: #28a745;
            margin-top: 5px;
        }

        .invoice-details p,
        .customer-info p {
            margin: 5px 0;
            font-size: 16px;
        }

        .product-list {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .product-list th,
        .product-list td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .product-list th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        .total {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #007bff;
            font-size: 14px;
            color: #666;
        }

    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header">
            <h2 class="invoice-title">Invoice</h2>
            <p class="thank-you">Thank you for your purchase!</p>
            <p>#{{ $invoice_code }}{{ $order->id }}</p>
        </div>

        <div class="customer-info">
            <h4>Shipping Address</h4>
            @if ($order->address)
            <p><strong>Name:</strong> {{ $order->address->first_name }} {{ $order->address->last_name }}</p>
            <p><strong>Address:</strong> {{ $order->address->street_address }}, {{ $order->address->city }}, {{ $order->address->state }} - {{ $order->address->zip_code }}</p>
            <p><strong>Phone:</strong> {{ $order->address->phone }}</p>
            @else
            <p>No address available.</p>
            @endif
        </div>

        <h4>Ordered Products</h4>
        <table class="product-list">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>$ {{ number_format($item->product->price, 2) }}</td>
                    <td>$ {{ number_format($item->total_amount, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p class="total">Total Price: ${{ number_format($order->grand_total, 2) }}</p>
        <p class="total">Shipping Method: {{ $order->shipping_method ?? 'Card' }}</p>
    </div>

    <div class="footer">
        <p>PCP Village, Sankat Tekthla, Phnom Penh, Cambodia</p>
        <p>Phone: +8558897666322 | Email: ecnshop@gmail.com</p>
        <p>&copy; Copyright Electronic Shop. All Rights Reserved.</p>
    </div>
</body>
</html>
