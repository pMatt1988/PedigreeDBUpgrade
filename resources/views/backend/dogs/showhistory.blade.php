{{--TODO style show history--}}
@extends('adminlte::page')

@section('content')
    <div class="container">
        @if($history)
            @php
                $model = json_decode($history->model_attributes);
            @endphp
            <div class="row bg-dark">
                <div class="col-2">Key</div>
                <div class="col">Value</div>
            </div>
            <div class='row'>
                <div class='col-2'>Name:</div>
                <div class='col'>{{$model->name}}</div>
            </div>
            <div class='row'>
                <div class='col-2'>Birth:</div>
                <div class='col'>{{$model->dob}}</div>
            </div>
            <div class='row'>
                <div class='col-2'>Sex:</div>
                <div class='col'>{{$model->sex}}</div>
            </div>
            <div class='row'>
                <div class='col-2'>Pre title:</div>
                <div class='col'>{{$model->pretitle}}</div>
            </div>
            <div class='row'>
                <div class='col-2'>Post title:</div>
                <div class='col'>{{$model->posttitle}}</div>
            </div>
            <div class='row'>
                <div class='col-2'>Reg #:</div>
                <div class='col'>{{$model->reg}}</div>
            </div>
            <div class='row'>
                <div class='col-2'>Color:</div>
                <div class='col'>{{$model->color}}</div>
            </div>
            <div class='row'>
                <div class='col-2'>Markings:</div>
                <div class='col'>{{$model->markings}}</div>
            </div>
            <div class='row'>
                <div class='col-2'>Website:</div>
                <div class='col'>{{$model->website}}</div>
            </div>
            <div class='row'>
                <div class='col-2'>Breeder:</div>
                <div class='col'>{{$model->breeder}}</div>
            </div>
            <div class='row'>
                <div class='col-2'>Owner:</div>
                <div class='col'>{{$model->owner}}</div>
            </div>


            <br>
            <a href="/backend/dogs/history/{{ $history->id }}/restore" class="btn btn-primary">Restore</a>
            <a href="/backend/dogs/history/{{ $history->id }}/delete" class="btn btn-danger">Delete</a>
        @else
            <div>Invalid History ID</div>
        @endif
    </div>
@endsection
