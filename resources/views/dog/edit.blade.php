@extends('frontend.layouts.app')

@section('title', config('app.name') .  ' edit ' . $dog->name)



@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">Edit "{{ $dog->name }}"</div>
                <div class="card-body">
                    @include('dog.masterform')
                </div><!--card-body-->
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->
@endsection
