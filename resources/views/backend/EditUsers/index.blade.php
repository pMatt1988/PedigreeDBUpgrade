@extends('adminlte::page');

@section('content')
    <div class="container">
        @foreach($users as $user)
            {{$user->email}}
        @endforeach
    </div>
@endsection
