@extends('layouts.app')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="card headcolor">
                <div class="card-header">
                        <h3 class="card-title pad-bot"><i class="material-icons">sim_card</i> <small>IMPORT IMEI</small> </h3>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 class="panel-title">Upload Imei List</h2>
                        </div>

                        <div class="panel-body">
                            <form class="" action="{{ URL::to('importExcel') }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                              <div class="form-group">
                                <div class="col-md-2">
                                    <span class="btn btn-round btn-file">
                                        <span class="fileinput-new">Browse</span> 
                                       <input id="imeifile" type="file" name="import_file" class="form-control">
                                    </span>
                                </div>
                                <div class="col-md-8">
                                    <pre class="pre-top-margin">Select File</pre>
                                </div>
                                <div>
                                <input type="submit" class="btn btn-tumblr pull-right" value="Upload">
                                </div>
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
