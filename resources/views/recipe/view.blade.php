@extends('adminlte::page')
@section('content')
<div class="container-fluid animated fadeIn">
    <div class="row">
        <div class="col-md-12">

            <!-- Default box -->
            <div class="">
                <div class="card no-padding no-border">
                    <table class="table table-striped mb-0">
                        <tbody>
                            <tr>
                                <td>
                                    <strong>Recipe Image:</strong>
                                </td>
                                <td>
                                    <img src="{{ $recipe->image }}" alt="" width="170" srcset="">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Recipe Name:</strong>
                                </td>
                                <td>
                                    <span>{{ $recipe->name }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Category:</strong>
                                </td>
                                <td>
                                    <span>{{ $recipe->menu->category->name }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Menu:</strong>
                                </td>
                                <td>
                                    <span>{{ $recipe->menu->name }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Prepration Time:</strong>
                                </td>
                                <td>
                                    <span>{{ $recipe->prepare_time }} minutes</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Serving:</strong>
                                </td>
                                <td>
                                    <span>{{ $recipe->serving }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Description:</strong>
                                </td>
                                <td>
                                    <span>
                                       {{ $recipe->description }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Date:</strong>
                                </td>
                                <td>
                                    <span data-order="2007-07-03 00:00:00">
                                        {{ $recipe->created_at }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Status:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ $recipe->status == 1 ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Ingredients:</strong>
                                </td>
                                <td>
                                    <span>
                                        @foreach ($recipe->ingredients as $item)
                                        {{ $item->ingredient .' '.$item->qty.' '.$item->unit }}<br/>
                                        @endforeach
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Instructions:</strong>
                                </td>
                                <td>
                                    <?php $i = 1;?>
                                    <span>
                                        @foreach ($recipe->instructions as $item)
                                        {{ $i++ }} -{{ $item->instruction }}<br/>
                                        @endforeach
                                    </span>
                                </td>
                            </tr>

                            {{-- <tr>
                                <td><strong>Actions</strong></td>
                                <td>
                                    <!-- Single edit button -->
                                    <a href="https://demo.backpackforlaravel.com/admin/article/1031/edit"
                                        class="btn btn-sm btn-link"><i class="la la-edit"></i> Edit</a>


                                    <a href="javascript:void(0)"
                                        onclick="if (!window.__cfRLUnblockHandlers) return false; cloneEntry(this)"
                                        data-route="https://demo.backpackforlaravel.com/admin/article/1031/clone"
                                        class="btn btn-sm btn-link" data-button-type="clone"><i class="la la-copy"></i>
                                        Clone</a>

                                    <a href="javascript:void(0)"
                                        onclick="if (!window.__cfRLUnblockHandlers) return false; deleteEntry(this)"
                                        data-route="https://demo.backpackforlaravel.com/admin/article/1031"
                                        class="btn btn-sm btn-link" data-button-type="delete"><i
                                            class="la la-trash"></i> Delete</a>


                                </td>
                            </tr> --}}
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->

        </div>
    </div>


</div>
@endsection
