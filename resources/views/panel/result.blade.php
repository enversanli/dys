
@if(Session::has('message'))
    <p class="alert text-gray-700">* {{ Session::get('message') }}</p>
@endif


@if($message)
    <p class="alert text-gray-700">{{$message}}</p>
    @endif

<p><a href="{{route('login')}}">Giriş</a> </p>
