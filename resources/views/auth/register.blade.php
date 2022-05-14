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

@endsection
