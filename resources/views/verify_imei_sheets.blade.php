@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    @if(Session::has('import_success_message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('import_success_message') }}</p>
                    @endif

                    @if(Session::has('import_error_message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('import_error_message') }}</p>
                    @endif
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 class="panel-title">Upload Imeis Sheet</h2>
                        </div>

                        <div class="panel-body">
                            <form class="import_to_excel" action="{{ URL::to('verify_imeis') }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="row">


                                    <div class="col-md-2">
                                        <label > Browse File 1<span style="color:red;">*</span></label>
                                    </div>
                                    <div class="col-md-3">
                                        <span>
                                           <input id="imeifile" type="file" name="import_file_one" class="textbox">
                                        </span>
                                    </div>
                                    <div class="col-md-1"></div>



                                    <div class="col-md-2">
                                        <label > Browse File 2<span style="color:red;">*</span></label>
                                    </div>
                                    <div class="col-md-3">
                                        <span>
                                           <input id="imeifile" type="file" name="import_file_two" class="textbox">
                                        </span>
                                    </div>
                                    <div class="col-md-1"></div>

                                    <div class="col-md-11">
                                        <div>
                                            <input type="submit" id="submit_btn" class="btn btn-primary pull-right" value="Upload">
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $('#submit_btn').click(function(e){
            e.preventDefault();
        });
    </script>
@endsection


