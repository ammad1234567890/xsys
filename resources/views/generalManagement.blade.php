@extends('layouts.app')

@section('content')
<div class="container">
      <div class="row">
          <div class="col-md-12">
              <div class="panel panel-default">
                  <div class="panel-heading">General Management</div>
                  <div class="panel-body">
                    <div class="column is-12">
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
                    </div>
                  </div>
              </div>
          </div>
    </div>
</div>
@endsection
