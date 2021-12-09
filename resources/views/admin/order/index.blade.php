@extends('adminlte::page')

@section('content')

<section class="content">
    <div class="row">
        <div class="col-12">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <div class="card">
                <div class="p-2 d-flex justify-content-between align-items-center">
                    <h5 class="">Orders</h5>
                    <div class="btn-group">
                        {{-- <a href="{{ route('category.create') }}" type="button" class="btn btn-default">Create</a> --}}
                         {{-- <button type="button" class="btn btn-default">SubCategories</button> --}}
                        <a target="_blank" href="{{ url('export/orders') }}" type="button" class="btn btn-default">Export</a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <table class="table table-sm dataTable" id="example1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Seller</th>
                                <th>Customer</th>
                                <th>Delivery</th>
                                <th>Payment</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Last Update</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($collection as $item)
                                <tr>
                                    <td> {{ $item->number}} </td>
                                    <td> {{ $item->seller->name}} </td>
                                    <td> {{ $item->customer->name}} </td>
                                    <td> {{ $item->delivery_date }} </td>
                                    <td> {{ $item->payment_date}} </td>
                                    <td> {{ $item->total_price}} €</td>
                                    <td> {{ $item->status}} </td>
                                    <td> {{ $item->updated_at}} </td>
                                    <td>
                                      <div class="btn-group">
                                        <a href="{{ route('order.show',[$item->id]) }}" class="btn-sm btn-default"><i class="fas fa-eye"></i></a>
                                        
                                      </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('plugins.Datatables', true)
@section('js')
<script>
$(function () {
    $("#example1").DataTable();
    $('.delete-user').click(function(e){
        e.preventDefault() // Don't post the form, unless confirmed
        if (confirm('Are you sure?')) {
            // Post the form
            $(this).siblings('form').submit() // Post the surrounding form
        }
    });
});
</script>
@endsection
