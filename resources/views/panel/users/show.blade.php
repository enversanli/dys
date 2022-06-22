@extends('layouts.panel')

@section('content')
<student-show :id="{{request()->id}}" :authUser="'SELAM'"></student-show>
@endsection
