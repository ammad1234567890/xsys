@extends('layouts.auth')
<style>
    .form-box input{
        border-radius:0px !important;
    }
</style>
@section('content')

    <div class="form-box">

        <form method="POST" action="{{ route('register') }}">
            <input type="text" placeholder="Full Name" name="name" value="{{ old('name') }}" required autofocus>
            {{ csrf_field() }}
            @if ($errors->has('name'))
                <span class="help-block" style="color:#fff;">
                     <strong>{{ $errors->first('name') }}</strong>
                 </span>
            @endif
            <input type="text" placeholder="Email Address" name="email" value="{{ old('email') }}" required>

            @if ($errors->has('email'))
                <span class="help-block" style="color:#fff;">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif

            <input type="text" placeholder="Staff Id" name="staff_id" value="{{ old('staff_id') }}" required autofocus>

            @if ($errors->has('staff_id'))
                <span class="help-block" style="color:#fff;">
                   <strong>{{ $errors->first('staff_id') }}</strong>
                </span>
            @endif

            <input type="password" placeholder="Password" class="form-control" name="password" required/>

            @if ($errors->has('password'))
                <span class="help-block" style="color:#fff;">
                   <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif

            <input type="password" placeholder="Confirm Password" name="password_confirmation" required />


            <button class="btn btn-info btn-block login" type="submit"  >Create Account</button>
            <br />
            <small class="">Already Registered User? Go to <a href="{{ route('login') }}" style="color:#fff;">Login</a></small>
        </form>
    </div>
@endsection

