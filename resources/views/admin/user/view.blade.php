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
                                    <strong>User Image:</strong>
                                </td>
                                <td>
                                    <img src="{{ $user->image }}" alt="" width="80" srcset="">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Name:</strong>
                                </td>
                                <td>
                                    <span>{{ $user->name }}</span>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong>First Name:</strong>
                                </td>
                                <td>
                                    <span>{{ $user->firstname }}</span>
                                </td>
                            </tr>

                            <tr><td><strong>User Name:</strong> </td><td> <span>{{ $user->username }}</span></td></tr>
                            <tr><td><strong>Address:</strong> </td><td> <span>{{ $user->address }}</span></td></tr>
                            <tr><td><strong>Address Line 2:</strong> </td><td> <span>{{ $user->address_line_2 }}</span></td></tr>
                            <tr><td><strong>Country:</strong> </td><td> <span>{{ $user->country }}</span></td></tr>
                            <tr><td><strong>Phone:</strong> </td><td> <span>{{ $user->phone }}</span></td></tr>
                            <tr><td><strong>VAT:</strong> </td><td> <span>{{ $user->vat }}</span></td></tr>
                            <tr><td><strong>Bank Account:</strong> </td><td> <span>{{ $user->bank_account }}</span></td></tr>
                            <tr><td><strong>Last Update:</strong> </td><td> <span>{{ $user->updated_at }}</span></td></tr>
                            <tr>
                                <td>
                                    <strong>Email:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ $user->email }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Member Since:</strong>
                                </td>
                                <td>
                                    <span data-order="2007-07-03 00:00:00">
                                        {{ $user->created_at }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Role:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ $user->role }}
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
