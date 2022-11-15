@extends('layouts.admin')

@section('css')
<style>
.error{
  color:red;
}
</style>
@endsection
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
              <a href="{{ route('settings.index') }}" class="btn btn-block btn-primary">View Setting</a>
            </div>

          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
              <li class="breadcrumb-item">Edit Setting</li>
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


  <div class="card">
    
    <div class="card-body">
      <form name="add-blog-post-form" id="add-blog-post-form" method="post" enctype="multipart/form-data" action="{{ route('settings.update', $record->id) }}">
       @method('PATCH')
       @csrf
       <div class="row">

        <div class="form-group col-md-6 col-sm-6 col-lg-6 col-xs-6">
          <label for="contact_email">Contact Email</label>
          <input type="email" id="contact_email" name="contact_email" value="{{ $record->contact_email }}" class="form-control" required="required">
          @error('contact_email')<div class="error">{{ $message }}</div>@enderror
        </div>
      

        <div class="form-group col-md-6 col-sm-6 col-lg-6 col-xs-6">
          <label for="contact_number">Contact Number</label>
          <input type="text" id="contact_number" name="contact_number" value="{{ $record->contact_number }}" class="form-control" required="required">
          @error('contact_number')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group col-md-6 col-sm-6 col-lg-6 col-xs-6">
          <label for="contact_whatsapp">Contact WhatsApp</label>
          <input type="text" id="contact_whatsapp" name="contact_whatsapp" value="{{ $record->contact_whatsapp }}" class="form-control">
          @error('contact_whatsapp')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group col-md-6 col-sm-6 col-lg-6 col-xs-6">
          <label for="google_account_link">Google URL</label>
          <input type="text" id="google_account_link" name="google_account_link" value="{{ $record->google_account_link }}" class="form-control">
          @error('google_account_link')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group col-md-6 col-sm-6 col-lg-6 col-xs-6">
          <label for="facebook_account_link">Facebook URL</label>
          <input type="text" id="facebook_account_link" name="facebook_account_link" value="{{ $record->facebook_account_link }}" class="form-control">
          @error('facebook_account_link')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group col-md-6 col-sm-6 col-lg-6 col-xs-6">
          <label for="youtube_account_link">Youtube URL</label>
          <input type="text" id="youtube_account_link" name="youtube_account_link" value="{{ $record->youtube_account_link }}" class="form-control">
          @error('youtube_account_link')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group col-md-12 col-sm-12 col-lg-12 col-xs-12">
          <label for="footer_text">Footer Text</label>
          <input type="text" id="footer_text" name="footer_text" value="{{ $record->footer_text }}" class="form-control">
          @error('footer_text')<div class="error">{{ $message }}</div>@enderror
        </div>

          <div class="form-group col-md-6 col-sm-6 col-lg-6 col-xs-6">
            <label for="header_logo">Header Logo</label>
            <input type="file" class="form-control" id="header_logo" name="header_logo">
          </div>

          <div class="form-group col-md-6 col-sm-6 col-lg-6 col-xs-6">
            <label for="footer_logo">Footer Logo</label>
            <input type="file" class="form-control" id="footer_logo" name="footer_logo">
          </div>

          @if( !empty($record->header_logo) )
          <div class="form-group col-md-6 col-sm-6 col-lg-6 col-xs-6">
            <strong>Thumbnail Header Logo </strong>
            <br/>
            <img src="{{ url('/thumbnail/') }}/{{ $record->header_logo }}" >
          </div>
          @endif

          @if( !empty($record->footer_logo) )
          <div class="form-group col-md-6 col-sm-6 col-lg-6 col-xs-6">
            <strong>Thumbnail Footer Logo </strong>
            <br/>
            <img src="{{ url('/thumbnail/') }}/{{ $record->footer_logo }}" >
          </div>
          @endif


        </div>
        <!--close row -->
            
        @can('setting-edit')
        <button type="submit" class="btn btn-primary">Update</button>
        @endcan
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