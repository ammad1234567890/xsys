@extends('layouts.auth')

@section('content')

<div class="wrapper wrapper-full-page">
        <div class="full-page register-page" filter-color="black">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                        <div class="card card-signup">
                            <h2 class="card-title text-center"><i class="fa fa-user"></i> SIGN UP</h2>
                            <div class="row">
                                <div class="col-md-11">
                                    <form class="form" method="POST" action="{{ route('register') }}">
                                        {{ csrf_field() }}
                                        <div class="card-content"> 
                                            <div class="text-center">
                                                <!-- <h4 class="card-title">Create Account</h4> -->
                                            </div>                                          
                                            <div class="input-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">person</i>
                                                </span>
                                                <input type="text" class="form-control" placeholder="Full Name..." name="name" value="{{ old('name') }}" required autofocus>

                                                @if ($errors->has('name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                                @endif

                                            </div>

                                            <div class="input-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">email</i>
                                                </span>
                                                <input type="text" class="form-control" placeholder="Email..." name="email" value="{{ old('email') }}" required>

                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif

                                            </div>

                                            <div class="input-group {{ $errors->has('staff_id') ? ' has-error' : '' }}">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">perm_identity</i>
                                                </span>
                                                <input type="text" class="form-control" placeholder="Staff Id..." name="staff_id" value="{{ old('staff_id') }}" required autofocus>

                                                @if ($errors->has('staff_id'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('staff_id') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="input-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">lock_outline</i>
                                                </span>

                                                <input type="password" placeholder="Password..." class="form-control" name="password" required/>

                                                @if ($errors->has('password'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">lock_outline</i>
                                                </span>
                                                <input type="password" placeholder="Confirm Password..." class="form-control" name="password_confirmation" required />
                                            </div>
                                        </div>
                                        <div class="footer text-center">
                                            <button type="submit" class="btn btn-primary btn-round">Sign up</button>
                                        </div>

                                        <div class="text-center col-md-12">
                                            <p> <small>Already Registered User? Click Here To
                                                    <a href="{{ route('login') }}"> Login
                                                    </a>
                                                </small>
                                            </p>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection

