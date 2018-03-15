@extends('layouts.auth')

@section('content')
<div class="wrapper wrapper-full-page">
        <div class="full-page register-page" filter-color="black">
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                            <form method="POST" action="{{ route('login') }}">
                                {{ csrf_field() }}
                                <div class="card card-login card-hidden">
                                    <div class="card-header text-center">
                                        <h4 class="card-title">SIGN IN</h4>
                                    </div>
                                    <div class="card-content">
                                                                      
                                        <div class="input-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                            <span class="input-group-addon">
                                                <i class="material-icons">email</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Email Address</label>
                                                <input type="text" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="input-group ">
                                            <span class="input-group-addon">
                                                <i class="material-icons">lock_outline</i>
                                            </span>
                                            <div class="form-group label-floating {{ $errors->has('password') ? ' has-error' : '' }}">
                                                <label class="control-label">Password</label>
                                                <input type="password" class="form-control" name="password" required>
                                                @if ($errors->has('password'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                                    </label>
                                                </div>
                                        </div>

                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-rose btn-wd btn-lg">Sign In</button>
                                    </div>


                                    <div class="row top-pad">

                                        <div class="text-left col-md-offset-1 col-md-5">
                                            <p> <small>
                                                    <a href="{{ route('register') }}">
                                                        <i class="material-icons">person_add</i>Register
                                                    </a> 
                                                </small>
                                            </p>
                                        </div>
                                        
                                        <div class="text-right col-md-5">
                                            <p> <small>
                                                    <a href="{{ route('password.request') }}">
                                                        <i class="material-icons">vpn_key</i>Forget Password
                                                    </a>
                                                </small>
                                            </p>
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
