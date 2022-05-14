@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="px-8 py-6 mx-4 mt-4 text-left bg-white shadow-lg md:w-1/3 lg:w-1/3 sm:w-1/3">
            <h3 class="text-2xl font-bold text-center">{{ __('Register') }}</h3>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <input type="hidden" name="role_key" value="{{\App\Support\Enums\UserRoleKeyEnum::ASSOCIATION_MANAGER->value}}">
                <div class="mt-4">
                    <div>
                        <label class="block" for="name">{{ __('Name') }}<label>
                                <input type="text" placeholder="Name"
                                       name="first_name"
                                       value="{{ old('first_name') }}" required autocomplete="first_name" autofocus
                                       class="@error('first_name') is-invalid @enderror w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600">
                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>


                    <div class="my-5">
                        <label class="block" for="last_name">{{ __('Last Name') }}<label>
                                <input type="text" placeholder="Last Name"
                                       name="last_name"
                                       value="{{ old('last_name') }}" required autocomplete="last_name" autofocus
                                       class="@error('last_name') is-invalid @enderror w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600">
                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>

                    <div class="my-5">
                        <label class="block" for="last_name">{{ __('common.association_name') }}<label>
                                <input type="text" placeholder="Name"
                                       name="association_name" value="{{ old('association_name') }}" required
                                       autocomplete="association_name" autofocus
                                       class="@error('association_name') is-invalid @enderror w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600">

                                @error('association_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label class="block" for="email">Email<label>
                                <input type="text" placeholder="{{__('common.email')}}"
                                       name="email" value="{{ old('email') }}" required autocomplete="email"
                                       class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="mt-4">
                        <label class="block">Password<label>
                                <input type="password" placeholder="Password"
                                       name="password"
                                       class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="mt-4">
                        <label class="block">Confirm Password<label>
                                <input type="password" placeholder="Password"
                                       name="password_confirmation" required autocomplete="new-password"
                                       class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600">
                                @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <span class="text-xs text-red-400">Password must be same!</span>
                    <div class="flex">
                        <button class="w-full px-6 py-2 mt-4 text-white bg-blue-600 rounded-lg hover:bg-blue-900">Create
                            Account
                        </button>
                    </div>
                    <div class="mt-6 text-grey-dark">
                        Already have an account?
                        <a class="text-blue-600 hover:underline" href="#">
                            Log in
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>
                    @if($errors->any())
                        <h4>{{$errors->first()}}</h4>
                    @endif
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <input type="hidden"
                                   value="{{\App\Support\Enums\UserRoleKeyEnum::ASSOCIATION_MANAGER->value}}"
                                   name="role_key">
                            <div class="row mb-3">
                                <label for="first_name"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="first_name" type="text"
                                           class="form-control @error('first_name') is-invalid @enderror"
                                           name="first_name" value="{{ old('first_name') }}" required
                                           autocomplete="first_name" autofocus>

                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="association_name"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Last Name') }}</label>

                                <div class="col-md-6">
                                    <input id="association_name" type="text"
                                           class="form-control @error('association_name') is-invalid @enderror"
                                           name="association_name" value="{{ old('association_name') }}" required
                                           autocomplete="association_name" autofocus>

                                    @error('association_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="first_name"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Association Name') }}</label>

                                <div class="col-md-6">
                                    <input id="last_name" type="text"
                                           class="form-control @error('last_name') is-invalid @enderror"
                                           name="last_name" value="{{ old('last_name') }}" required
                                           autocomplete="last_name" autofocus>

                                    @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
