@extends('Frontend.layout.sidenav-layout')
@section('content')
    @include('Frontend.component.leave.leave-page');
    @include('Frontend.component.leave.leave-add');
    @include('Frontend.component.leave.leave-delete');
    @include('Frontend.component.leave.leave-approve');
    @include('Frontend.component.leave.leave-reject');
@endsection