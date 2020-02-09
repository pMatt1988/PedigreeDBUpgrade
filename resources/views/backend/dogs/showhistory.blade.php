@extends('adminlte::page')

@section('content')
    <div class="container">
        @if($history)
            @php
                $model = json_decode($history->model);
                echo "
                <div>Name: {$model->name}</div>
                <div>Birth: {$model->dob}</div>
                <div>Sex: {$model->sex}</div>
                <div>Pretitle: {$model->pretitle}</div>
                <div>Posttitle: {$model->posttitle}</div>
                <div>Reg#: {$model->reg}</div>
                <div>Color: {$model->color}</div>
                <div>Markings: {$model->markings}</div>
                <div>Website: {$model->website}</div>
                <div>Breeder: {$model->breeder}</div>
                <div>Owner: {$model->owner}</div>
                "
            @endphp
            <a href="#">Restore</a>
            <a href="/backend/dogs/history/{{ $history->id }}/delete">Delete</a>
        @else
            <div>Invalid History ID</div>
        @endif
    </div>
@endsection
