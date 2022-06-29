@extends('layouts.panel')

@section('content')
    @php $authUser = auth()->user()->load('role')->toJson();  @endphp
    <student-show :id="{{request()->id}}" :authUser='{{$authUser}}'></student-show>
@endsection
