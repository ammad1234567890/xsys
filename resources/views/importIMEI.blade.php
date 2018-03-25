@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 class="panel-title">Upload IMEI List</h2>
                        </div>

                        <div class="panel-body">
                            <form class="" action="{{ URL::to('importExcel') }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-2">
                                        <label > Browse</label>
                                    </div>
                                    <div class="col-md-5">
                                        <span>
                                           <input id="imeifile" type="file" name="import_file" class="textbox">
                                        </span>
                                    </div>
                                    <div class="col-md-1"></div>
                                    
                                    <div class="col-md-5">
                                        <div>
                                            <input type="submit" class="btn btn-success pull-right" value="Upload">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
