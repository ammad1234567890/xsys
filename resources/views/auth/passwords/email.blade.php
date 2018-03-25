@extends('layouts.auth')

@section('content')
<h1>Reset Password</h1>

                                <div class="form-box">
                                    @if (session('status'))
                                        <div class="alert alert-success">
                                            {{ session('status') }}
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('password.email') }}">
                                        {{ csrf_field() }}


                                                <input id="email" type="email" placeholder="Email Address" name="email" value="{{ old('email') }}" required>

                                                @if ($errors->has('email'))
                                                    <span class="help-block" style="color:#fff;">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif



                                                <button type="submit"  class="btn btn-info btn-block login">
                                                    Send Password Reset Link
                                                </button>

                                    </form>
                                        <br />
                                        <small class=""><a href="{{ route('login') }}" style="color:#fff;">Login</a> | <a href="{{ route('register') }}" style="color:#fff;">Register</a></small>
                                </div>

@endsection
