@extends('layouts.app')
@section('content')
 
<main class="container-fluid">  
<div class="container breadcrumbs">
  <div class="row justify-content-between" style="font-size: x-large;
    color: #03226a;">
    <div class="col-5">
      <div class="row justify-content-start">
    <div class="col-1">
      <a href="{{ route('home') }}" class="text-decoration-none"><i class="fa-solid fa-backward breadcrumbsicon"></i></a>
    </div>
    <div class="col-4 backicon breadcrumbstext">
  INVOICE
    </div>
  </div>
    </div>
    <div class="col-7" >
         <div class="btn-list" style=" float: right;">
            <button class="btn btn-primary d-none d-sm-inline-block" onclick="printReceipt('thermal')">Print</button>
                    <!-- <button class="btn btn-success d-none d-sm-inline-block" onclick="printReceipt('a4')">Print A4</button>  -->
                     <a href="{{ route('sales.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                         Back to Sales
                     </a>
                 </div> 
    </div>
  </div>
  
</div>
   <style>
        /* Thermal Receipt Styles */
        .receipt-thermal {
            width: 80mm;
            margin: 0 auto;
            font-family: 'Courier New', Courier, monospace;
            border: 1px dashed #ccc;
            padding: 8px;
        }

        /* A4 Receipt Styles */
        .receipt-a4 {
            width: 210mm;
            margin: 0 auto;
            font-family: Arial, sans-serif;
            border: 1px solid #ccc;
            padding: 20px;
            background: white;
        }

        .receipt-a4 .logo-text {
            font-size: 32px;
            margin-bottom: 15px;
        }

        .receipt-a4 .receipt-header p {
            font-size: 16px;
        }

        .receipt-a4 .item-row {
            font-size: 16px;
            padding: 5px 0;
        }

        .receipt-a4 .total-section {
            font-size: 18px;
            margin: 20px 0;
        }

        /* Common Styles */
        .logo-text {
            font-weight: bold;
            text-align: center;
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 10px;
        }

        .receipt-header p {
            margin: 0;
        }

        .divider {
            border-top: 1px dotted #000;
            margin: 5px 0;
        }

        .total-section {
            font-weight: bold;
        }

        .footer-text {
            text-align: center;
            margin-top: 10px;
        }

        /* Print Styles */
        @page {
            size: auto;
            margin: 0mm;
        }
        
        @page thermal {
            size: 80mm auto;
            margin: 0mm;
        }
        
        @page a4 {
            size: A4;
            margin: 15mm;
        }
        
        @media print {
            /* Hide everything by default */
            body * {
                visibility: hidden;
            }
            
            /* Hide all buttons and controls */
            .no-print, .btn, .container {
                display: none !important;
            }

            /* Thermal Print Style */
            body.thermal-mode .receipt-thermal,
            body.thermal-mode .receipt-thermal * {
                visibility: visible;
            }
            
            body.thermal-mode {
                width: 80mm;
                height: auto;
                page: thermal;
            }
            
            body.thermal-mode .receipt-thermal {
                position: absolute;
                left: 0;
                top: 0;
                width: 80mm;
                margin: 0;
                padding: 8px;
                border: none !important;
                page-break-after: avoid;
            }
            
            body.thermal-mode .receipt-a4 {
                display: none;
            }

            /* A4 Print Style */
            body.a4-mode .receipt-a4,
            body.a4-mode .receipt-a4 * {
                visibility: visible;
            }
            
            body.a4-mode .receipt-a4 {
                position: absolute;
                left: 0;
                top: 0;
                width: 210mm;
                margin: 0;
                padding: 20px;
                border: none !important;
            }
            
            body.a4-mode .receipt-thermal {
                display: none;
            }

            /* Reset background colors for printing */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>

 
<!-- ///////////////// -->
  <div class="row justify-content-center">

    <div class="col-6">
<div class="card text-center">
  <div class="card-header listtablehead">
   INVOICE
  </div>
  <div class="card-body">
 <!-- //////////// -->
      <div class="container mt-4 no-print">
        <div class="row justify-content-center mb-4">
            <div class="col-auto">
                <div class="btn-group" role="group">
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Thermal Receipt -->
    <div class="receipt-thermal">
        <div class="logo-text">BABY TOTO</div>
        <div class="receipt-header">
            <p>Kids Accessories</p>
            <p>123 11111Street</p>
            <p>Phone: 9969217</p>
            <p id="date-thermal"></p>
            <p>Receipt #: <span>{{ $sale->invoice_number }}</span></p>
        </div>

        <div class="divider"></div>

        <div class="items-section">
             <div class="item-row d-flex justify-content-between">
                <span class="col-6" style="text-align: left;">ITEM</span>
                <span class="col-2"> Qty</span>
                <span class="col-4 text-end">Price</span>
            </div>
              @foreach($sale->items as $item)
            <div class="item-row d-flex justify-content-between">
                <span class="col-6"style="text-align: left;">{{ $item->inventory->name }}</span>
                <span class="col-2"> {{ $item->quantity }}x</span>
                <span class="col-4 text-end"> {{ number_format($item->subtotal, 2) }}</span>
            </div>
             @endforeach
        </div>

        <div class="divider"></div>

        <div class="total-section">
            <div class="d-flex justify-content-between">
                <span>Subtotal:</span>
                <span>Mvr {{ number_format($sale->subtotal, 2) }}</span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Tax (8%):</span>
                <span>Mvr {{ number_format($sale->tax, 2) }}</span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Discount:</span>
                <span>Mvr {{ number_format($sale->discount, 2) }}</span>
            </div>
            
            <div class="divider"></div>
            <div class="d-flex justify-content-between">
                <span>TOTAL:</span>
                <span>Mvr {{ number_format($sale->total, 2) }}</span>
            </div>
        </div>

        <div class="divider"></div>

        <div class="payment-info text-center" style=" font-size: smaller;">
            <p style="margin-bottom: 0px; ">Payment Method: {{ ucfirst($sale->payment_method) }}</p> 
            <p style="margin-bottom: 0px; ">Thank you for shopping at Baby Toto!</p>
           <p style="margin-bottom: 0px; ">Return Policy: Within 7 days with receipt</p>
           <p style="margin-bottom: 0px; ">Follow us @babytoto</p>
        </div> 
    </div>

    <!-- A4 Receipt -->
    <!-- <div class="receipt-a4">
         <h3 class="font-bold text-gray-700 mb-2">Bill To:</h3>
                                     @if($sale->customer)
                                     <p>{{ $sale->customer->first_name }} {{ $sale->customer->last_name }}</p>
                                     @if($sale->customer->email)
                                     <p>{{ $sale->customer->email }}</p>
                                     @endif
                                     @if($sale->customer->phone)
                                     <p>{{ $sale->customer->phone }}</p>
                                     @endif
                                     @if($sale->customer->address)
                                     <p>{{ $sale->customer->address }}</p>
                                     @endif
                                     @else
                                     <p>Walk-in Customer</p>
                                     @endif
                                 </div>
        <div class="row">
            <div class="col-12">
                <div class="logo-text">BABY TOTO</div>
                <div class="receipt-header">
                    <p>Kids Fashion & Accessories</p>
                    <p>123 Fashion Street</p>
                    <p>Phone: (555) 123-4567</p>
                    <p id="date-a4"></p>
                    <p>Receipt #: BT-2025001</p>
                </div>

                <div class="divider"></div>

                <div class="items-section">
                    <div class="row fw-bold mb-2">
                        <div class="col-6">Item</div>
                        <div class="col-2 text-center">Quantity</div>
                        <div class="col-2 text-end">Unit Price</div>
                        <div class="col-2 text-end">Total</div>
                    </div>
                    <div class="item-row row">
                        <div class="col-6">Baby Romper</div>
                        <div class="col-2 text-center">2</div>
                        <div class="col-2 text-end">$14.99</div>
                        <div class="col-2 text-end">$29.98</div>
                    </div>
                    <div class="item-row row">
                        <div class="col-6">Soft Toys</div>
                        <div class="col-2 text-center">1</div>
                        <div class="col-2 text-end">$12.99</div>
                        <div class="col-2 text-end">$12.99</div>
                    </div>
                    <div class="item-row row">
                        <div class="col-6">Baby Socks</div>
                        <div class="col-2 text-center">3</div>
                        <div class="col-2 text-end">$2.99</div>
                        <div class="col-2 text-end">$8.97</div>
                    </div>
                </div>

                <div class="divider"></div>

                <div class="total-section">
                    <div class="row">
                        <div class="col-8 text-end">Subtotal:</div>
                        <div class="col-4 text-end">$51.94</div>
                    </div>
                    <div class="row">
                        <div class="col-8 text-end">Tax (8%):</div>
                        <div class="col-4 text-end">$4.16</div>
                    </div>
                    <div class="divider"></div>
                    <div class="row">
                        <div class="col-8 text-end">TOTAL:</div>
                        <div class="col-4 text-end">$56.10</div>
                    </div>
                </div>

                <div class="divider"></div>

                <div class="payment-info text-center">
                    <p>Payment Method: CASH</p>
                    <p>Amount Paid: $60.00</p>
                    <p>Change: $3.90</p>
                </div>

                <div class="footer-text">
                    <p>Thank you for shopping at Baby Toto!</p>
                    <p>Return Policy: Within 7 days with receipt</p>
                    <p>Follow us @babytoto</p>
                </div>
            </div>
        </div>
    </div> -->
  <!-- ///////////// -->



  </div>
  <div class="card-footer text-muted">
  
  </div>
</div>
    </div>  
  </div>
</main>

 
    <script>
 
        const currentDate = new Date().toLocaleString();
        document.getElementById('date-thermal').textContent = currentDate;
        document.getElementById('date-a4').textContent = currentDate;
 
        function printReceipt(format) { 
            document.body.className = format === 'thermal' ? 'thermal-mode' : 'a4-mode';
             
            window.print();
             
            setTimeout(() => {
                document.body.className = '';
            }, 1000);
        }
    </script>
 

 @endsection












 