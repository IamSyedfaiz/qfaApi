@extends('layouts.app')

@section('content')
    <!-- Content -->
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="index.html" class="app-brand-link gap-2">
                                <img src="{{ asset('public/admin/assets/img/logo.jpg') }}" alt="logo" class="img-fluid">
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-5 text-center">Login</h4>
                        <!-- <p class="mb-4 ">Please sign-in to your account</p> -->
                        @if (session('danger'))
                            <div class="alert alert-danger">
                                {{ session('danger') }}
                            </div>
                        @endif
                        <form method="POST" id="formAuthentication" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                {{-- <input type="text" class="form-control" id="email" name="email-username"
                                    placeholder="Enter your email" autofocus /> --}}
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>

                                </div>
                                <div class="input-group input-group-merge">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember-me" />
                                    <label class="form-check-label" for="remember-me"> Remember Me </label>
                                </div>
                            </div> --}}
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                                {{-- <a class="btn btn-primary d-grid w-100" href="admin.html">
                                    <span>Admin</span>
                                </a> --}}
                                {{-- <a class="btn btn-primary d-grid w-100 mt-2" href="{{ route('register') }}">
                                    <span>Register</span>
                                </a> --}}
                            </div>
                        </form>
                        <p class="text-center">
                            <span>Forgot Password?</span>
                            <a href="{{ route('password.request') }}">
                                <span>Reset Password</span>
                            </a>
                        </p>
                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>
    <!-- / Content -->
@endsection
