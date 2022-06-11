@extends('layouts.panel')

@section('content')
<show-class :id="{{request()->id}}"></show-class>
@endsection
