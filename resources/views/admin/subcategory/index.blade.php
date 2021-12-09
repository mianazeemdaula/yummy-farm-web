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
                    <h5 class="">
                        {{ \App\Models\Category::find($id)->name }} 
                    </h5>
                    <div class="btn-group">
                        <a href="{{ route('sub.category.create', $id) }}" type="button" class="btn btn-default">Create</a>
                         {{-- <button type="button" class="btn btn-default">SubCategories</button> --}}
                        {{-- <button type="button" class="btn btn-default">Excel</button> --}}
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-sm dataTable" id="example1">
                        <thead>
                            <tr>
                                <th>Sr #</th>
                                <th>Name</th>
                                <th>Last Update</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($collection as $item)
                                <tr>
                                    <td> {{ $item->id}} </td>
                                    <td> {{ $item->name}} </td>
                                    <td> {{ $item->updated_at}} </td>
                                    <td>
                                      <div class="btn-group">
                                        {{-- <a href="{{ route('sub.category.index',[$item->id]) }}" class="btn-sm btn-default"><i class="fas fa-eye"></i></a> --}}
                                        <a href="{{ route('sub.category.edit',[$item->super_category_id,$item->id]) }}" type="button" class="btn-sm btn-default"><i class="fas fa-edit"></i></a>
                                        {{-- <a href="#" class="btn-sm btn-default"><i class="fas fa-trash"></i></a> --}}
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
});
</script>
@endsection
