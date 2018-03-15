@extends('layouts.app')

@section('content')
<div class="content">

                <div class="container-fluid">
                        <div class="row">
                            <div class="card headcolor">
                                <div class="card-header">
                                        <h3 class="card-title pad-bot"><i class="material-icons">dashboard</i> <small>COLLECTION </small> </h3>
                                </div>
                            </div>
                        </div>
                    <div class="row">
                        <collection-component></collection-component>
                    </div>
                    
                </div>
        </div>
@endsection