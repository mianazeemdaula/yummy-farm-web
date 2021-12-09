@extends('adminlte::page')
@section('content')
<div class="container-fluid animated fadeIn">
    <div class="row">
        <div class="col-md-12">

            <div class="invoice p-3 mb-3">
                <!-- title row -->
                <div class="row">
                  <div class="col-12">
                    <h4>
                      <img src="{{ asset('images/logo.png')}}" alt="" width="100px" srcset=""> Yummy Farms
                      <small class="float-right">Date: {{ \Carbon\Carbon::now() }}</small>
                    </h4>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                  <div class="col-sm-4 invoice-col">
                    From
                    <address>
                      <strong>{{ $order->customer->name }}</strong><br>
                      {{ $order->customer->address }}<br>
                      {{ $order->customer->address_line_2 }}<br>
                      Phone: {{ $order->customer->phone }}<br>
                      Email: {{ $order->customer->email }}<br>
                    </address>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 invoice-col">
                    To
                    <address>
                        <strong>{{ $order->seller->name }}</strong><br>
                        {{ $order->seller->address }}<br>
                        {{ $order->seller->address_line_2 }}<br>
                        Phone: {{ $order->seller->phone }}<br>
                        Email: {{ $order->seller->email }}<br>
                    </address>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 invoice-col">
                    <b>Invoice #{{ $order->number }}</b><br>
                    <br>
                    <b>Order ID:</b> {{ $order->id }}<br>
                    <b>Payment Due:</b> {{ $order->payment_date }}<br>
                    <b>Order Date:</b> {{ $order->created_at }}<br>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
  
                <!-- Table row -->
                <div class="row">
                  <div class="col-12 table-responsive">
                    <table class="table table-striped">
                      <thead>
                      <tr>
                        <th>Qty</th>
                        <th>Product</th>
                        <th>Delivery Method</th>
                        <th>Subtotal</th>
                      </tr>
                      </thead>
                      <tbody>
                      @foreach ($order->details as $item)
                        <tr>
                            <td>{{ $item->qty }}</td>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ str_replace('_','',$item->delivery_type) }}</td>
                            <td>€ {{ $item->price * $item->qty }}</td>
                        </tr>
                      @endforeach
                      </tbody>
                    </table>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
  
                <div class="row">
                  <!-- accepted payments column -->
                  <div class="col-6">
                    ...
                  </div>
                  <!-- /.col -->
                  <div class="col-6">
                    <div class="table-responsive">
                      <table class="table">
                        <tbody><tr>
                          <th style="width:50%">Subtotal:</th>
                          <td>€{{ round($order->total_price / 1.21,2) }}</td>
                        </tr>
                        <tr>
                          <th>VAT (21%)</th>
                          <td>€{{ round($order->total_price / 1.21 , 2) }}</td>
                        </tr>
                        <tr>
                          <th>Shipping:</th>
                          <td>€{{ $order->total_charges}}</td>
                        </tr>
                        <tr>
                          <th>Total:</th>
                          <td>€{{ $order->total_price  + $order->total_charges}}</td>
                        </tr>
                      </tbody></table>
                    </div>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
        </div>
    </div>

</div>
@endsection
