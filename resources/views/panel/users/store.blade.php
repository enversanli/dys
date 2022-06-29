@extends('layouts.panel')

@section('content')
    {{dd("asdd")}}
    <student-show :id="''" :authUser="{{auth()->user()->load('role')}}"></student-show>
@endsection
