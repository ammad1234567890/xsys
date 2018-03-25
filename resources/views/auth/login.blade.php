@extends('layouts.auth')

@section('content')
    <div class="form-box">

        <form method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            @if ($errors->has('email'))
                <span class="help-block" style="color:white;">
                   <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
            <input type="text" placeholder="Email Address" name="email" value="{{ old('email') }}" autofocus required>

            <input type="password" placeholder="password" name="password" required>
            @if ($errors->has('password'))
                <span class="help-block">
                   <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif

            <div style="float:left;" width="100%">
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} style="width: auto;">
                <span style="    position: relative;
    top: -16px;
    font-weight: bold;
    left: 9px;">Remember Me</span>
            </div>



            <button class="btn btn-info btn-block login" type="submit" >Login</button>
            <br />
            <small class=""><a href="{{ route('password.request') }}"  style="color:#fff;">Forgot Details</a> | <a href="{{url('/register')}}" style="color:#fff;">Create an Account</a></small>
        </form>
    </div>



@endsection
