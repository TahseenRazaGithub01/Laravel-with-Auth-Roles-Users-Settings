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
              <a href="{{ route('users.index') }}" class="btn btn-block btn-primary">View User</a>
            </div>

          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
              <li class="breadcrumb-item">Edit User</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <!--main area -->
    <div class="container mt-4">
  @if(session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
  @endif
  <div class="card">
    
    <div class="card-body">
      <form name="add-blog-post-form" id="add-blog-post-form" method="post" action="{{ route('users.update', $record->id) }}">
       @method('PATCH')
       @csrf
        <div class="form-group">
          <label for="name">Name</label>
          <input type="name" id="name" name="name" value="{{ $record->name }}" class="form-control" required="">
          @error('name')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" value="{{ $record->email }}" class="form-control" required="">
          @error('email')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" class="form-control" >
          @error('password')<div class="error">{{ $message }}</div>@enderror
        </div>

         <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Role:</strong>
                    {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple')) !!}
                </div>
            </div>
            

        <button type="submit" class="btn btn-primary">Update</button>
      </form>

      <br>
      <div class='log_information'>
        @if(!empty($logs['created_log']) )
            <p class="log_information" style=""><strong>Created info :</strong>
                {{ $logs['created_log']['timestamp'] }} ,
                {{ $logs['created_log']['by'] }} ,
                {{ $logs['created_log']['agent_ip'] }}
            </p>
            
        @endif

        @if(!empty($logs['modified_log']) )
            <p class="modified_log" style="font-size:13px;"><strong>Updated info :</strong>
                {{ $logs['modified_log']['timestamp'] }} ,
                {{ $logs['modified_log']['by'] }} ,
                {{ $logs['modified_log']['agent_ip'] }}
            </p>
            
        @endif

      </div>
    </div>
  </div>
</div> 
    <!--close main area -->
    

    
@endsection