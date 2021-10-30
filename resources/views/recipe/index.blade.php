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
                <div class="card-header">
                    <h3 class="card-title">
                        List of Recipes
                    </h3>
                </div>
                <div class="card-body">
                    <div class="py-2">
                        <a href="{{ route('recipe.create') }}" class="btn btn-primary" >Add Recipe</a>
                    </div>
                    <table class="table table-sm dataTable" id="example1">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Prepration Time</th>
                                <th>Updated</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recipes as $recipe)
                                <tr>
                                    <td> <img src="{{ $recipe->image}}" width="50" alt="" srcset=""> </td>
                                    <td> {{ $recipe->name}} </td>
                                    <td> {{ $recipe->description }} </td>
                                    <td> {{ $recipe->prepare_time }} </td>
                                    <td> {{ $recipe->updated_at}} </td>
                                    <td>
                                      <div class="btn-group">
                                          <a href="{{ route('recipe.show',[$recipe->id]) }}" type="button" class="btn-sm btn-default"><i class="fas fa-eye"></i></a>
                                          <a href="{{ route('recipe.edit',[$recipe->id]) }}" type="button" class="btn-sm btn-default"><i class="fas fa-edit"></i></a>
                                          <a href="#" class="btn-sm btn-default delete-user"><i class="fas fa-trash"></i></a>
                                            <form method="POST" action="{{ route('recipe.destroy', $recipe->id) }}">
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
