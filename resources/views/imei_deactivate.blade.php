@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    @if(Session::has('deactivate_success_message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('deactivate_success_message') }}</p>
                    @endif

                    @if(Session::has('deactivate_error_message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('deactivate_error_message') }}</p>
                    @endif
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 class="panel-title">Upload Imeis Sheet</h2>
                        </div>

                        <div class="panel-body">
                            <form class="import_to_excel" action="{{ URL::to('deactivate') }}" method="post">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-2">
                                        <label >Enter IMEI number<span style="color:red;">*</span></label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="textbox" name="imei" required/>
                                    </div>

                                    <div class="col-md-12"><div>
                                            <input type="submit" id="submit_btn" class="btn btn-primary" value="De-Activate">
                                        </div></div>


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
