@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 class="panel-title">Upload IMEI List</h2>
                        </div>

                        <div class="panel-body">
                            <form class="" action="{{ URL::to('importExcel') }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="row">                                    
                                    <div class="col-md-2">
                                        <label >Select Product<span style="color:red;">*</span></label>
                                    </div>
                                    <div class="col-md-2">
                                        <select required="" name="product">
                                            <option value="" class="textbox">Select Produc</option>
                                            @foreach($products as $product)
                                                <option value="{{$product->id}}">{{$product->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label > Browse File<span style="color:red;">*</span></label>
                                    </div>
                                    <div class="col-md-3">
                                        <span>
                                           <input id="imeifile" type="file" name="import_file" class="textbox">
                                        </span>
                                    </div>
                                    <!-- <div class="col-md-1"></div> -->
                                    
                                    <div class="col-md-5">
                                        <div>
                                            <input type="submit" class="btn btn-primary pull-right" value="Upload">
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
