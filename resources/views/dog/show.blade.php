@extends('frontend.layouts.app')

@section('title', config('app.name') . ' | ' . "Dog Name!")
@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>Dog Name</strong>
                </div><!--card-header-->
                <div class="card-body">

                    <div class="row">
                        <div class="col-3">
                            @if($dog->image_url != null)
                                <img src="{{'/storage/pedigree-img/' . $dog->image_url}}" alt="blah" class="img-fluid">
                                <img src="{{'/storage/pedigree-img/thumbnails/' . $dog->image_url}}" alt="blah"
                                     class="img-fluid">
                            @endif
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="col-2 text-right">Name:</div>
                                <div class="col">{{ $dog->name }}</div>

                            </div>

                            <div class="row">
                                <div class="col-2 text-right">Sire:</div>

                                <div class="col">
                                    @if($dog->father())
                                        <a href="/dogs/{{ $dog->father()->id }}">{{ $dog->father()->name }}</a>
                                    @else
                                        N/A
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-2 text-right">Dam:</div>

                                <div class="col">
                                    @if($dog->mother())
                                        <a href="/dogs/{{ $dog->mother()->id }}">{{ $dog->mother()->name }}</a>
                                    @else
                                        N/A
                                    @endif
                                </div>
                            </div>

                            @if($dog->dob)
                                <div class="row">
                                    <div class="col-2 text-right">Dob:</div>

                                    <div class="col">
                                        {{ $dog->dob->format('m/d/Y') }}
                                    </div>
                                </div>
                            @endif

                            @if($dog->sex)
                                <div class="row">
                                    <div class="col-2 text-right">Sex:</div>

                                    <div class="col">
                                        {{ $dog->sex }}
                                    </div>
                                </div>
                            @endif

                            @if($dog->pretitle)
                                <div class="row">
                                    <div class="col-2 text-right">Pre-title:</div>

                                    <div class="col">
                                        {{ $dog->pretitle }}
                                    </div>
                                </div>
                            @endif

                            @if($dog->posttitle)
                                <div class="row">
                                    <div class="col-2 text-right">Post-title:</div>

                                    <div class="col">
                                        {{ $dog->posttitle }}
                                    </div>
                                </div>
                            @endif

                            @if($dog->reg)
                                <div class="row">
                                    <div class="col-2 text-right">Reg #:</div>

                                    <div class="col">
                                        {{ $dog->reg }}
                                    </div>
                                </div>
                            @endif

                            @if($dog->color)
                                <div class="row">
                                    <div class="col-2 text-right">Color:</div>

                                    <div class="col">
                                        {{ $dog->color }}
                                    </div>
                                </div>
                            @endif

                            @if($dog->markings)
                                <div class="row">
                                    <div class="col-2 text-right">Markings:</div>

                                    <div class="col">
                                        {{ $dog->markings }}
                                    </div>
                                </div>
                            @endif

                            @if($dog->website)
                                <div class="row">
                                    <div class="col-2 text-right">Website:</div>

                                    <div class="col">
                                        {{ $dog->website }}
                                    </div>
                                </div>
                            @endif

                            @if($dog->breeder)
                                <div class="row">
                                    <div class="col-2 text-right">Breeder:</div>

                                    <div class="col">
                                        {{ $dog->breeder }}
                                    </div>
                                </div>
                            @endif

                            @if($dog->owner)
                                <div class="row">
                                    <div class="col-2 text-right">Owner:</div>

                                    <div class="col">
                                        {{ $dog->owner }}
                                    </div>
                                </div>
                            @endif


                        </div>

                    </div>
                </div><!--card-body-->
            </div><!--card-->
            <br>


            <div>

                <a href="/dogs/{{ $dog->id }}/pedigree/4" class="btn btn-success">Pedigree</a>
                @auth()
                    @if(Auth::id() == $dog->user_id || Auth::user()->can('Edit All Dogs'))
                        <a href="/dogs/{{ $dog->id }}/edit" class="btn btn-primary">Edit</a>
                        @include('partials.delete-button', ['btnurl' => "/dogs/{$dog->id}/delete", 'msg' => 'You are about to delete ' . $dog->name])
                    @endif
                    @can('View Backend')
                        <a href="/backend/dogs/{{$dog->id}}" class="btn btn-info">Admin</a>
                    @endcan
                @endauth
            </div>


        </div><!--col-->
    </div><!--row-->
@endsection
