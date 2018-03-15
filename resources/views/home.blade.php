@extends('layouts.app')

@section('content')

        <div class="content">

                <div class="container-fluid">
                        <div class="row">
                            <div class="card headcolor">
                                <div class="card-header">
                                        <h3 class="card-title pad-bot"><i class="material-icons">dashboard</i> <small>DASHBOARD </small> </h3>
                                </div>
                            </div>
                        </div>
                    <div class="row">
                        <retailerbox-component></retailerbox-component>
                        <manufactureorder-component></manufactureorder-component>
                        <totalproduct-component></totalproduct-component>
                        <totalwarehouse-component></totalwarehouse-component>
                        <activeproduct-component></activeproduct-component>
                        <totalemployeesbox-component></totalemployeesbox-component>
                    </div>
                    <div class="row">
                        <salereport-component></salereport-component>
                        <regionwisereport-component></regionwisereport-component>
                    </div>
                    <div class="row">
                        <productstats-component></productstats-component>
                    </div>
                </div>
        </div>
@endsection
