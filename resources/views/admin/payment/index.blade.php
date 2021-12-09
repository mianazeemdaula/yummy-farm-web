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
                    <h5 class="">Payment</h5>
                    <div class="btn-group">
                        {{-- <a href="{{ route('category.create') }}" type="button" class="btn btn-default">Create</a> --}}
                         {{-- <button type="button" class="btn btn-default">SubCategories</button> --}}
                        <a target="_blank" href="{{ url('export/payments') }}" type="button" class="btn btn-default">Export</a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <table class="table table-sm dataTable" id="example1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order #</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th>Last Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($collection as $item)
                                <tr>
                                    <td> {{ $item->id}} </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> {{ $item->updated_at}} </td>
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
