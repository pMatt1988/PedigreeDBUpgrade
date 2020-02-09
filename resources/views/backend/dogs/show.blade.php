@extends('adminlte::page')

@section('content')
    <div class="row bg-dark">
        <div class="col-2">Key</div>
        <div class="col">Value</div>
    </div>
    <div class='row'>
        <div class='col-2'>Name:</div>
        <div class='col'>{{$dog->name}}</div>
    </div>
    <div class='row'>
        <div class='col-2'>Sire:</div>
        <div class='col'>
            <a href="/backend/dogs/{{ $dog->father()->id ?? '#' }}">{{$dog->father()->name ?? ''}}</a>
        </div>
    </div>

    <div class='row'>
        <div class='col-2'>Dam:</div>
        <div class='col'>
            <a href="/backend/dogs/ {{ $dog->mother()->id ?? '#' }}">{{$dog->mother()->name ?? ''}}</a>
        </div>
    </div>
    <div class='row'>
        <div class='col-2'>Birth:</div>
        <div class='col'>{{$dog->dob}}</div>
    </div>
    <div class='row'>
        <div class='col-2'>Sex:</div>
        <div class='col'>{{$dog->sex}}</div>
    </div>
    <div class='row'>
        <div class='col-2'>Pre title:</div>
        <div class='col'>{{$dog->pretitle}}</div>
    </div>
    <div class='row'>
        <div class='col-2'>Post title:</div>
        <div class='col'>{{$dog->posttitle}}</div>
    </div>
    <div class='row'>
        <div class='col-2'>Reg #:</div>
        <div class='col'>{{$dog->reg}}</div>
    </div>
    <div class='row'>
        <div class='col-2'>Color:</div>
        <div class='col'>{{$dog->color}}</div>
    </div>
    <div class='row'>
        <div class='col-2'>Markings:</div>
        <div class='col'>{{$dog->markings}}</div>
    </div>
    <div class='row'>
        <div class='col-2'>Website:</div>
        <div class='col'>{{$dog->website}}</div>
    </div>
    <div class='row'>
        <div class='col-2'>Breeder:</div>
        <div class='col'>{{$dog->breeder}}</div>
    </div>
    <div class='row'>
        <div class='col-2'>Owner:</div>
        <div class='col'>{{$dog->owner}}</div>
    </div>

    <br>
    <a href="/backend/dogs/{{ $dog->id }}/history" class="btn btn-primary">History</a>
    @include('partials.delete-button', ['btnurl' => "/dogs/{$dog->id}/delete", 'msg' => 'You are about to delete ' . $dog->name])
{{--    <a href="/backend/dogs/{{ $dog->id }}/delete" class="btn btn-danger">Delete</a>--}}
@endsection

