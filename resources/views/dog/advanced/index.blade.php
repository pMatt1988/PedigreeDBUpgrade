@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . "Advanced Search")

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>Advanced Search</strong>
                </div><!--card-header-->
                <div class="card-body">
                    @include('dog.advanced.form')

                    @if($result !== null)
                        @include('dog.advanced.results')
                    @endif
                </div><!--card-body-->
            </div><!--card-->

        </div><!--col-->
    </div><!--row-->
@endsection
