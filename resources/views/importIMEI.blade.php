@extends('layouts.app')

@section('content')
<div class="content">
    <div class="container-fluid">
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <form class="" action="{{ URL::to('importExcel') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                      <div class="form-group">
                       <span class="btn btn-round btn-file">
                            <span class="fileinput-new">Select image</span> 
                           <input type="file" name="import_file" class="form-control btn btn-default">
                        </span>
                        <input type="submit" class="btn btn-default" value="Upload IMEI">
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection