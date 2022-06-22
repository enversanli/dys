@extends('layouts.panel')

@section('content')
    <student-show :id="''" :authUser="{{auth()->user()->load('role')}}"></student-show>
@endsection
