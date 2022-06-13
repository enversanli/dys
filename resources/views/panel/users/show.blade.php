@extends('layouts.panel')

@section('content')
<student-show :id="{{request()->id}}"></student-show>
@endsection
