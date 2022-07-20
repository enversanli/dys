@extends('layouts.panel')

@section('content')
<daily-attendances :authUser="{{auth()->user()->load('role')}}"></daily-attendances>
@endsection
