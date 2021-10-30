@extends('adminlte::page')

@section('content')

<section class="content">
    {!! form_start($form) !!}
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
                        Create Recipe
                    </h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            {!! form_row($form->menu_id) !!}
                        </div>
                        <div class="col-md-4">
                            {!! form_row($form->name) !!}
                        </div>
                        <div class="col-md-1">
                            {!! form_row($form->prepare_time) !!}
                        </div>
                        {{-- <div class="col-md-1">
                            {!! form_row($form->serving) !!}
                        </div> --}}
                        <div class="col-md-4">
                            {!! form_row($form->image) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            {!! form_row($form->description) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        Ingredients
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            {!! form_row($form->ingredient_category_id) !!}
                        </div>
                        <div class="col-md-3">
                            {!! form_row($form->ingredient_name) !!}
                        </div>
                        <div class="col-md-3">
                            {!! form_row($form->ingredient_qty) !!}
                        </div>
                        <div class="col-md-2">
                            {!! form_row($form->ingredient_unit_id) !!}
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <a style="margin-top:30px" type="submit" class="btn btn-primary text-white" id="add-row">Add</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <table id="ingrdient-table" class="table table-sm">
                            <thead>
                                <tr>
                                    <td>Category</td>
                                    <td>Ingredient</td>
                                    <td>Qty</td>
                                    <td>Unit</td>
                                    <td style="width: 10%" >Action</td>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        Instructions
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-11">
                            {!! form_row($form->instruction) !!}
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <a style="margin-top:30px" type="submit" class="btn btn-primary text-white" id="add-instruction">Add</a>
                            </div>
                        </div>
                    </div>
                    <div>
                        <ol id="insturctions" class="list-group">

                        </ol>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-info">Save</button>
                    <button type="submit" class="btn btn-default float-right">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    {!! form_end($form) !!}
</section>
@endsection


@section('plugins.Select2', true)

@section('js')
<script src={{asset("js/sortable.js") }}></script>
<script>
    $(document).ready(function(){

        var units = @json($units);
        var ingredientCategories = @json($ingredientCategories);

        $('#category_id').select2();
        $("#add-row").click(function(){
            var unitId = $("#ingredient_unit_id").val();
            var unitName = $("#ingredient_unit_id option:selected").html();
            var qty = $("#ingredient_qty").val();
            var ingredientName = $("#ingredient_name").val();
            var cat = $("#ingredient_category_id").val().trim();
            if(ingredientName == null || ingredientName.length == 0){
                return;
            }
            $("#ingrdient-table tbody").append(insertIngredient(ingredientName,qty,unitId, cat));
            $("#ingredient_qty").val(1);
            $("#ingredient_name").val(null);
        });

        $('body').on('click', '.cancel', function(){
            $(this).parents("tr").remove();
            return false;
        });
        $('body').on('click', '.remove-instruction', function(){
            $(this).parents("li").remove();
            return false;
        });

        $("#add-instruction").click(function(){
            var instruction = $("#instruction").val();
            if(instruction == '') return;
            $('#insturctions').append('<li class="list-group-item"><div class="row"><div class="col-md-11"><input value="'+instruction+'" type="text" class="form-control" name="instruction[]"></div><a href="#" class="remove-instruction"><i class="fas fa-trash"></i></div></li>');
            $('#instruction').val(null);
        })

        $("#insturctions").sortable();

        function insertIngredient(ingredient, qty, unit, cat ) {
            var select = '<select class="form-control" name="unit[]">';
            units.forEach(e => {
                if(unit == e.id){
                select +='<option selected value="'+e.id+'">'+e.name+'</option>';
                }else{
                    select +='<option value="'+e.id+'">'+e.name+'</option>';
                }
            });
            select += '</select>';

            var category = '<select class="form-control" name="ingredientcat[]">';
            ingredientCategories.forEach(e => {
                if(cat == e.id){
                    category +='<option selected value="'+e.id+'">'+e.name+'</option>';
                }else{
                    category +='<option value="'+e.id+'">'+e.name+'</option>';
                }
            });
            category += '</select>';
            return `<tr>
                <td>`+category+`</td>
                <td><input class="form-control" type="text" name="ingredient[]" value="`+ingredient+`"></td>
                <td><input class="form-control" type="text" name="qty[]" value="`+qty+`"></td>
                <td>`+select+`</td>
                <td><a href="#" class="cancel"><i class="fas fa-trash"></i></td>
            </tr>`;
        }
    });
</script>

@endsection
