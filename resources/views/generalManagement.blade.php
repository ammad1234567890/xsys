@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="card headcolor">
                    <div class="card-header">
                          <h3 class="card-title pad-bot"><i class="material-icons">devices_other</i> <small>OTHERS</small> </h3>
                    </div>
                </div>
                    <div>
                        @if(in_array('city', $permissions))
                            <city-component></city-component>
                        @endif
                    </div>
                    <div>
                        @if(in_array('region', $permissions))
                            <region-component></region-component>
                        @endif
                    </div>
                    <div>
                        @if(in_array('department', $permissions))
                            <department-component></department-component>
                        @endif
                    </div>
                    <div>
                        @if(in_array('staffType', $permissions))
                            <stafftype-component></stafftype-component>
                        @endif
                    </div>
                    <div>
                        @if(in_array('designation', $permissions))
                            <designation-component></designation-component>
                        @endif
                    </div>
                    <div>
                        @if(in_array('payment', $permissions))
                            <payment-component></payment-component>
                        @endif
                    </div>
                    <div>
                        @if(in_array('currency', $permissions))
                            <currency-component></currency-component>
                        @endif
                    </div>
                    <div>
                        @if(in_array('receivestatus', $permissions))
                            <receivestatus-component></receivestatus-component>
                        @endif
                    </div>
                    <div>
                        @if(in_array('warehouseType', $permissions))
                            <warehousetype-component></warehousetype-component>
                        @endif
                    </div>
            </div>
        </div>
    </div>


@endsection
