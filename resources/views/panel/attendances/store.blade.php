@extends('layouts.panel')

@section('content')
<store-daily-attendances :authUser="{{auth()->user()->load('role')}}"></store-daily-attendances>
@endsection
