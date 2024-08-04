@extends('layouts.auth.app')

@section('content')
    @php
        $title = 'login';
    @endphp
    <div class="row align-items-center">
        <div class="col-lg-7 p-3">
            <img src="{{ asset('/img/login-img.png') }}" alt="" class="d-none d-lg-block" />
        </div>
        <div class="col-lg-5">
            <div class="login-box bg-white shadow-lg border-radius-10">
                <div class="login-title">
                    <h2 class="text-center  " style="color: #4169E1;">Login To {{ env('APP_NAME') }}</h2>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    {{-- <div class="select-role">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn active">
                                <input type="radio" name="options" id="admin" />
                                <div class="icon">
                                    <img src="{{ asset('backend_theme') }}/vendors/images/briefcase.svg" class="svg"
                                        alt="" />
                                </div>
                                <span>I'm</span>
                                Manager
                            </label>
                            <label class="btn">
                                <input type="radio" name="options" id="user" />
                                <div class="icon">
                                    <img src="{{ asset('backend_theme') }}/vendors/images/person.svg" class="svg"
                                        alt="" />
                                </div>
                                <span>I'm</span>
                                Employee
                            </label>
                        </div>
                    </div> --}}
                    <div class="input-group custom">
                        <input type="email" class="form-control form-control-lg" placeholder="Email address"
                            name="email" required />
                        <div class="input-group-append custom">
                            <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                        </div>
                    </div>
                    @error('email')
                        <span class="text-danger" role="alert">
                            <small>{{ $message }}</small>
                        </span>
                    @enderror
                    <div class="input-group custom">
                        <input type="password" class="form-control form-control-lg" placeholder="**********"
                            name="password" />
                        <div class="input-group-append custom">
                            <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                        </div>
                    </div>
                    @error('password')
                        <span class="text-danger" role="alert">
                            <small>{{ $message }}</small>
                        </span>
                    @enderror
                    <div class="row pb-30">
                        <div class="col-6">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input"name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }} />
                                <label class="custom-control-label" for="remember">Remember</label>
                            </div>
                        </div>
                        {{-- <div class="col-6">
                            <div class="forgot-password">
                                <a href="{{ route('password.request') }}">Forgot Password</a>
                            </div>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group mb-0">
                                <button type="submit" class="btn btn-lg btn-block text-white"
                                    style="background-color: #4169E1;">Sign
                                    In</button>
                            </div>
                            {{-- <div class="font-16 weight-600 pt-10 pb-10 text-center" data-color="#707373">
                                OR
                            </div>
                            <div class="input-group mb-0">
                                <a class="btn btn-outline-warning btn-lg btn-block" href="{{ route('register') }}">Register
                                    To Create
                                    Account</a>
                            </div> --}}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
