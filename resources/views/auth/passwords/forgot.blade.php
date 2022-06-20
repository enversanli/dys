@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="px-8 py-6 mx-4 mt-4 text-left bg-white shadow-lg md:w-1/3 lg:w-1/3 sm:w-1/3">
            <h3 class="text-2xl font-bold text-center">{{ __('auth.forgotPassword') }}</h3>
            <form method="POST" action="{{ route('password.update') }}">

                <input type="hidden" name="role" value="{{request()->role ?? null}}">
                <input type="hidden" name="association" value="{{request()->association ?? null}}">
                @csrf
                <input type="hidden" name="role_key"
                       value="{{\App\Support\Enums\UserRoleKeyEnum::ASSOCIATION_MANAGER->value}}">
                <div class="mt-4">

                    <div class="mt-4">
                        <label class="block" for="email">{{__('input.email')}}<label>
                                <input type="text" placeholder="{{__('input.email')}}"
                                       name="email" value="{{ old('email') }}" required autocomplete="email"
                                       class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong class="text-sm text-red-600">{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="text-center">
                        <button
                            type="submit"
                            class="block mx-auto my-5 px-7 py-3 bg-blue-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"
                        >
                            {{ __('auth.resetPassword') }}
                        </button>

                        <small class="mt-4 block mb-2">or</small>
                        <a class="text-blue-600 hover:underline" href="{{route('auth.login')}}">
                            {{__('auth.login')}}
                        </a>
                    </div>
                </div>

            </form>
        </div>
    </div>

@endsection
