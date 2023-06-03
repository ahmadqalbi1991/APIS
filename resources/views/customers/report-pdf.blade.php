<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .pdf-wrapper {
            padding: 20px;
            border: 2px solid #d1d1d1;
            margin: 10px 0;
        }

        .user-info h4 {
            color: #000;
            margin-bottom: 1rem;
        }

        .user-info strong {
            color: #8d8d8d;
            font-size: 16px;
        }

        .underline {
            text-decoration: underline;
        }

        .table table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .table table td, .table table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .table table tr:nth-child(even){background-color: #f2f2f2;}

        .table table tr:hover {background-color: #ddd;}

        .table table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }
    </style>
</head>
<body>
<div class="pdf-wrapper">
    <div class="user-info">
        <div class="w33">
            <h4><strong>Name:</strong> {{ $data->user->name }}</h4>
        </div>
        <div class="w33">
            <h4><strong>Email:</strong> {{ $data->user->email }}</h4>
        </div>
        <div class="w33">
            <h4><strong>Contact Number:</strong> +{{ $data->user->code }}-{{ $data->user->number }}</h4>
        </div>
    </div>
</div>
<div class="pdf-wrapper">
    <h3 class="underline">Assets</h3>
    @foreach($data->assets as $asset)
        <div class="user-info">
            <div class="w33">
                <h4><strong>Model:</strong> {{ $asset->model }}</h4>
            </div>
            <div class="w33">
                <h4><strong>Manufacture:</strong> {{ $asset->manufacture }}</h4>
            </div>
            <div class="w33">
                <h4><strong>Serial:</strong> {{ $asset->serial }}</h4>
            </div>
            <div class="w33">
                <h4><strong>Status:</strong> {{ $asset->status }}</h4>
            </div>
            <div class="w33">
                <h4><strong>Weight:</strong> {{ $asset->weight }}</h4>
            </div>
            <div class="table">
                <h5>Orders</h5>
                <table>
                    <tr>
                        <th>Order #</th>
                        <th>Total</th>
                    </tr>
                    @foreach($asset->orders as $order)
                        <tr>
                            <td>INV_{{ $order->id }}</td>
                            <td>${{ $order->price + $order->tax + $order->service_charges }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <hr>
    @endforeach
</div>
</body>
</html>
