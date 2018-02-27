@extends('layouts.app')

@section('content')

        <div class="col-md-12">
            <div class="panel">
                <h3 class="panel-heading">Dashboard</h3>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">

        <div class="col-sm-6 col-md-3 paddingmarginzero">
          <div class="row-stat">
            <p class="row-stat-label">Inventory</p>
            <h3 class="row-stat-value">Purchases</h3>
            <span class="label label-success row-stat-badge">+43%</span>
          </div> <!-- /.row-stat -->
        </div> <!-- /.col -->

        <div class="col-sm-6 col-md-3 paddingmarginzero">
          <div class="row-stat">
            <p class="row-stat-label">Inventory</p>
            <h3 class="row-stat-value">Sales</h3>
            <span class="label label-success row-stat-badge">+17%</span>
          </div> <!-- /.row-stat -->
        </div> <!-- /.col -->

        <div class="col-sm-6 col-md-3 paddingmarginzero">
          <div class="row-stat">
            <p class="row-stat-label"> Inventory</p>
            <h3 class="row-stat-value">Total</h3>
            <span class="label label-success row-stat-badge">+26%</span>
          </div> <!-- /.row-stat -->
        </div> <!-- /.col -->

        <div class="col-sm-6 col-md-3 paddingmarginzero">
          <div class="row-stat">
            <p class="row-stat-label">Currently Active Users</p>
            <h3 class="row-stat-value">19</h3>
            <span class="label label-danger row-stat-badge">+5%</span>
          </div> <!-- /.row-stat -->
        </div> <!-- /.col -->
        
      </div> <!-- /.row -->
                </div>
            </div>
        </div>
@endsection
