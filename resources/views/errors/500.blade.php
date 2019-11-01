@extends('errors.minimal')

@section('title')
    {{$message??__('Server Error')}}
@endsection
@section('code', '500')
@section('message')
    {{$message??__('Server Error')}}
@endsection
