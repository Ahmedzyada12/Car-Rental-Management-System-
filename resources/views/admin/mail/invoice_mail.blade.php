<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        tr.odd {
            background-color: #eee;
        }

        p {
            padding-bottom: 7px;
            margin: 0
        }
    </style>
</head>

<body>
    <div style="padding: 20px">
        <h1 style="text-align: center">hello
            {{ $invoice->customers->first_name ? $invoice->customers->first_name . ' ' . $invoice->customers->last_name : '' }}
        </h1>
        <p>we are from cars company</p>
        <p>location: {{ $company->address }} </p>
        <p>phone: {{ $company->phone }} </p>
        <h2>This invoice has been sent to you</h2>
        <table style="width: 100%; border: 1px solid #000">
            <tr class="odd">
                <td style="width: 30px">1-</td>
                <td style="width: 150px">name: </td>
                <td> {{ $invoice->customers->first_name ? $invoice->customers->first_name . ' ' . $invoice->customers->last_name : '' }}
                </td>
            </tr>
            <tr>
                <td style="width: 30px">2-</td>
                <td style="width: 150px">due paid</td>
                <td>{{ $invoice->due_date }}</td>
            </tr>
            <tr class="odd">
                <td style="width: 30px">3-</td>
                <td style="width: 150px">status of invoice</td>
                <td>{{ $invoice->status == 1 ? 'Paid' : ($invoice->status == 2 ? 'Unpaid' : 'Partial Paid') }}</td>
            </tr>
            <tr>
                <td style="width: 30px">4-</td>
                <td style="width: 150px">price</td>
                <td>{{ $invoice->amount }}</td>
            </tr>
            <tr class="odd">
                <td style="width: 30px">5-</td>
                <td style="width: 150px">You paid</td>
                <td>{{ $invoice->paid }}</td>
            </tr>
            <tr>
                <td style="width: 30px">6-</td>
                <td style="width: 150px">remaining</td>
                <td>{{ $invoice->amount - $invoice->paid }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
