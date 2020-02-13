@extends('adminlte::page');

@section('content')
    <div class="container">
        <div class="row bg-dark">
            <div class="col"><b>Name</b></div>
            <div class="col-3"><b>Created On</b></div>
        </div>
        @foreach($history as $entry)
            @php
                $model = json_decode($entry->model_attributes);
            @endphp
            <div class="row">
                <div class="col"><a href="/backend/dogs/history/{{ $entry->id }}">{{$model->name}}</a></div>
                <div class="col-3"> {{$entry->created_at}}</div>
            </div>

        @endforeach
    </div>
@endsection
