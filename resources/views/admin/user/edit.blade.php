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
                        User Form
                    </h3>
                </div>
                {!! form_start($form) !!}
                <div class="card-body">
                    {!! form_rest($form) !!}
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">Update</button>
                    <a  class="btn btn-default float-right" href="{{ route('user.index') }}">Cancel</a>
                </div>
                {!! form_end($form) !!}
            </div>
        </div>
    </div>
</section>
@endsection
