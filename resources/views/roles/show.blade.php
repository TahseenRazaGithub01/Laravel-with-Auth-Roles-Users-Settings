@extends('layouts.admin')

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">


        <div class="row mb-2">
          <div class="col-sm-6">
            <div class="col-sm-4"></div>

            <div class="col-sm-4">
              <a href="{{ route('roles.index') }}" class="btn btn-block btn-primary">View Roles</a>
            </div>

          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
              <li class="breadcrumb-item">Show Role</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->



        <div class="">
            <div class="">
                <div class="form-group">
                    <strong>Name:</strong>
                    {{ $role->name }}
                </div>
            </div>
            <div class="">
                <div class="form-group">
                    <strong>Permissions:</strong><br/>
                    @if(!empty($rolePermissions))
                        @foreach($rolePermissions as $v)
                            <label class="label label-success">{{ $v->name }}, </label>                            
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
@endsection
