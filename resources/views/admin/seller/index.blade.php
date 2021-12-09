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
                    <h5 class="">Sellers</h5>
                    <div class="btn-group">
                        {{-- <a href="{{ route('category.create') }}" type="button" class="btn btn-default">Create</a> --}}
                         {{-- <button type="button" class="btn btn-default">SubCategories</button> --}}
                        <a target="_blank" href="{{ url('export/sellers') }}" type="button" class="btn btn-default">Export</a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <table class="table table-sm dataTable" id="example1">
                        <thead>
                            <tr>
                                <th>ID #</th>
                                <th>Avatar</th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Last Update</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($collection as $item)
                                <tr>
                                    <td> {{ $item->id}} </td>
                                    <td> <img src="{{ $item->image}}" width="40" alt="" class="rounded-circle" srcset=""> </td>
                                    <td> {{ $item->username}} </td>
                                    <td> {{ $item->name}} </td>
                                    <td> {{ $item->email}} </td>
                                    <td> {{ $item->status}} </td>
                                    <td> {{ $item->updated_at}} </td>
                                    <td>
                                      <div class="btn-group">
                                        <a href="{{ route('seller.show',[$item->id]) }}" class="btn-sm btn-default"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('seller.edit',[$item->id]) }}" type="button" class="btn-sm btn-default"><i class="fas fa-edit"></i></a>

                                        <a href="#" class="btn-sm btn-default delete-user"><i class="fas fa-trash"></i></a>
                                            <form method="POST" action="{{ route('seller.destroy', $item->id) }}">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                            </form>
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
