@extends('layouts.panel')

@section('content')
<duesses-list :authUser="{{auth()->user()->load('role')}}"></duesses-list>
@endsection
