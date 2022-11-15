@extends('layouts.admin')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
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
              <li class="breadcrumb-item">Add User</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->

      </div>

    </div>


    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

<div class="container mt-4">

    <div class="card">
        
        <div class="card-body">

            <form name="add-blog-post-form" id="add-blog-post-form" method="post" action="{{ route('roles.store')}}">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="name" id="name" name="name" value="{{ old('name') }}" class="form-control" required="">
                @error('name')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <strong>Permission:</strong>
                <br/>
                <?php $count = 0; ?>
                @foreach($permission as $value)
                <?php $count = $count + 1; ?>
                    <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                    {{ $value->name }} &nbsp;&nbsp; </label>
                    <?php if($count == 4){ ?>
                    <br/>
                <?php $count = 0; } ?>
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>

    </div>

</div>

@endsection