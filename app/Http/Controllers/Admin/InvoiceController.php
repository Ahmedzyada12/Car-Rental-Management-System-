<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\InvoiceMail;
use App\Models\About;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('admin.invoices.index');
    }

    public function apidataInvoices()
    {
        $invoices = Invoice::with('customers')->get();
        // return $invoices;
        $transformedData = $invoices->map(function ($invoice) {
            return [
                'id' => $invoice->id,
                'customer' => @$invoice->customers->first_name, // Adjust according to your model
                'due_date' => $invoice->due_date, // Adjust according to your model
                'status' => $invoice->status,
                'amount' => $invoice->amount,
                'paid' => $invoice->paid,
                'Remaining' => $invoice->amount - $invoice->paid,
            ];
        });
        $jsonData = json_encode(['data' => $transformedData]);
        return $jsonData;
    }

    public function apidataInvoicesDashboard()
    {
        $invoices = Invoice::with('customers')->latest('created_at')->take(7)->get();
        // return $invoices;
        $transformedData = $invoices->map(function ($invoice) {
            return [
                'id' => $invoice->id,
                'customer' => @$invoice->customers->first_name, // Adjust according to your model
                'due_date' => $invoice->due_date, // Adjust according to your model
                'status' => $invoice->status,
                'amount' => $invoice->amount,
                'paid' => $invoice->paid,
                'Remaining' => $invoice->amount - $invoice->paid,
            ];
        });
        $jsonData = json_encode(['data' => $transformedData]);
        return $jsonData;
    }

    public function create()
    {
        $customers = User::where('role', 3)->get();
        // return $customers;
        return view('admin.invoices.create', compact('customers'));
    }
    public function store(Request $request)
    {
        if ($request->status == 3) {
            $data = $request->validate([
                'customer' => 'required|max:255',
                'amount' => 'required|numeric',
                'due_date' => 'required|date',
                'status' => 'required|in:1,2,3',
                'payment_method' => 'required|max:255',
                'paid' => 'required'
            ]);
        } else {
            $data = $request->validate([
                'customer' => 'required|max:255',
                'amount' => 'required|numeric',
                'due_date' => 'required|date',
                'status' => 'required|in:1,2,3',
                'payment_method' => 'required|max:255',
            ]);
        }

        // $customer = User::find($request->customer);
        $data['email'] = $request->email;
        if ($request->status == 1) {
            $data['paid'] = $request->amount;
        } else if ($request->status == 2) {
            $data['paid'] = 0;
        } else {
            if ($request->paid > $request->amount) {
                return back()->with('more_than', 'paid number must be equal or less than amount');
            }
        }
        $invoice = Invoice::create($data);

        $details = new InvoiceDetail();
        $details->invoice_id = $invoice->id;
        $details->paid = $invoice->paid;
        if ($invoice->status == 2) {
            $details->status = 'unpaid';
        } else if ($invoice->status == 3) {
            $details->status = 'Partially paid';
        } else {
            $details->status = 'paid';
        }
        $details->save();

        return back()->with('success', 'added successfully');
    }
    public function show($id)
    {
        $invoice = Invoice::with('customers')->where('id', $id)->first();
        $customers = User::where('role', 3)->get();
        // return $invoice;
        return view('admin.invoices.edit', compact('invoice', 'customers'));
    }
    public function edit($id, Request $request)
    {
        $data = $request->validate([
            'customer' => 'required|max:255',
            'amount' => 'required|numeric',
            'due_date' => 'required|date',
            'payment_method' => 'required|max:255',
        ]);
        // $customer = User::find($request->customer);
        $data['email'] = $request->email;
        $invoice = Invoice::find($id);
        $invoice->update($data);
        return back()->with('success', 'updated successfully');
    }

    public function changeStatus(Request $request)
    {
        if ($request->status == 3) {
            $data = $request->validate([
                'status' => 'required|in:1,2,3',
                'paid' => 'required|numeric'
            ]);
        } else {
            $data = $request->validate([
                'status' => 'required|in:1,2,3',
            ]);
        }

        $invoice = Invoice::findOrFail($request->invoice_id);
        // return $invoice;

        if ($request->status == 1) {
            $data['paid'] = $invoice->amount;
        } else if ($request->status == 2) {
            $data['paid'] = 0;
        } else {
            if ($request->paid > ($invoice->amount - $invoice->paid)) {
                return back()->with('more_than', 'paid number must be equal or less than amount');
            } else if (($invoice->paid + $request->paid) == $invoice->amount) {
                $data['status'] = 1;
                $data['paid'] = $invoice->amount;
            } else {
                $data['paid'] = $invoice->paid + $request->paid;
            }
        }
        $invoice->update($data);
        // return $invoice;

        $details = new InvoiceDetail();
        $details->invoice_id = $invoice->id;

        if ($request->status == 1) {
            // $details->paid = $invoice->amount - $invoice->paid;
            $details->paid = $invoice->amount;
        } else if ($request->status == 2) {
            $details->paid = 0;
        } else {
            $details->paid = $request->paid;
        }

        if ($invoice->status == 2) {
            $details->status = 'unpaid';
        } else if ($invoice->status == 3) {
            $details->status = 'Partially paid';
        } else {
            $details->status = 'paid';
        }
        $details->save();

        return back()->with('success', 'added successfully');
    }
    public function delete($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        return back();
    }
    public function details($id)
    {
        $invoice = Invoice::findOrFail($id);
        return view('admin.invoices.details', compact('invoice'));
    }

    public function api_invoice_details($id)
    {
        $invoices = InvoiceDetail::where('invoice_id', $id)->get();
        // return $invoices;
        $transformedData = $invoices->map(function ($invoice) {
            return [
                'id' => $invoice->id,
                'created_at' => Carbon::parse($invoice->created_at)->format('y-m-d'),
                'paid' => $invoice->paid,
                'status' => $invoice->status,
                // 'Remaining' => $invoice->amount - $invoice->paid,
            ];
        });
        $jsonData = json_encode(['data' => $transformedData]);
        return $jsonData;
    }
    public function invoiceMail($id)
    {
        $invoice = Invoice::with('details')->findOrFail($id);
        $company = About::find(1);

        $name = $invoice->customers->first_name;
        $address = $company->address;
        $phone = $company->phone;
        $due_date = $invoice->due_date;
        $amount = $invoice->amount;
        $paid = $invoice->paid;
        $rem = $amount - $paid;
        $status = $invoice->status == 1 ? 'Paid' : ($invoice->status == 2 ? 'Unpaid' : 'Partial Paid');

        $to = $invoice->email;
        $subject = "Test Email";
        // $headers = "From: ahmedmohamedfawzi35@gmail.com";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        $message = <<<EOF
        <!DOCTYPE html>
        <html>

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
                $name
            </h1>
            <p>we are from cars company</p>
            <p>location: $address </p>
            <p>phone: $phone </p>
            <h2>This invoice has been sent to you</h2>
            <table style="width: 100%; border: 1px solid #000">
                <tr class="odd">
                    <td style="width: 30px">1-</td>
                    <td style="width: 150px">name: </td>
                    <td> $name
                    </td>
                </tr>
                <tr>
                    <td style="width: 30px">2-</td>
                    <td style="width: 150px">due paid</td>
                    <td>$due_date</td>
                </tr>
                <tr class="odd">
                    <td style="width: 30px">3-</td>
                    <td style="width: 150px">status of invoice</td>
                    <td>$status</td>
                </tr>
                <tr>
                    <td style="width: 30px">4-</td>
                    <td style="width: 150px">price</td>
                    <td>$amount</td>
                </tr>
                <tr class="odd">
                    <td style="width: 30px">5-</td>
                    <td style="width: 150px">You paid</td>
                    <td>$paid</td>
                </tr>
                <tr>
                    <td style="width: 30px">6-</td>
                    <td style="width: 150px">remaining</td>
                    <td>$rem</td>
                </tr>
            </table>
        </div>
        </body>

        </html>
        EOF;

        // return $message;
        // Send the email
        if ($invoice->email) {
            mail($to, $subject, $message, $headers);
        } else {
            return back()->with('not_found', 'first add email to this user ' . $invoice->customers->first_name);
        }
        // return back()->with('mail', 'send email successfully to ' . $invoice->customers->first_name);
        // mail($to, $subject, $message, $headers);
        return back()->with('mail', 'send email successfully to ' . $invoice->customers->first_name);


        // return $company;
        // if ($invoice->email) {
        //     Mail::to($invoice->email)->send(new InvoiceMail($invoice, $company));
        // } else {
        //     return back()->with('not_found', 'first add email to this user ' . $invoice->customers->first_name);
        // }
        // return back()->with('mail', 'send email successfully to ' . $invoice->customers->first_name);
    }
}
