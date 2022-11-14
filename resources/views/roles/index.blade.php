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

            @can('role-create')
            <div class="col-sm-4">
              <a href="{{ route('roles.create') }}" class="btn btn-block btn-primary">Create Role</a>
            </div>
            @endcan
            
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
              <li class="breadcrumb-item">Role Management</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->


      </div>
    </div>


  @if ($message = Session::get('success'))
      <div class="alert alert-success">
          <p>{{ $message }}</p>
      </div>
  @endif

  <section class="content">
    <div class="container-fluid">
      <div class="row">
      <div class="col-12">
              <div class="card">
                <div class="card-header">

                  <p>
                    Displaying {{$roles->count()}} of {{ $roles->total() }} role(s).
                  </p>

                  <div class="card-body table-responsive p-0">
                  <table class="table table-hover text-nowrap">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th width="280px">Action</th>
                      </tr>
                    </thead>
                    <tbody>

                    @if ($roles->count() == 0)
                    <tr>
                        <td colspan="3">No roles to display.</td>
                    </tr>
                    @endif

                    @foreach ($roles as $key => $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>

                        <td>
                            
                            @can('role-edit')
                                <a class="btn btn-info" href="{{ route('roles.show',$role->id) }}">Show</a>
                                <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>
                            @endcan

                            @can('role-delete')
                                {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger', 'onclick' => 'return confirm("Are you sure to delete role?")']) !!}
                                {!! Form::close() !!}

                                
                                
                            @endcan
                        </td>
                    </tr>
                    @endforeach

                    </tbody>
                  </table>
                  
                  {!! $roles->appends(Request::all())->links() !!}

                </div>



                </div>
              </div>
      </div>

      </div>
    </div>
  </section>
@endsection