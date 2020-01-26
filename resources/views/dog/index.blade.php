@extends('frontend.layouts.app')

@section('title', config('app.name'))


@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    @can('Create Dog')
                        <a class="btn btn-primary my-2" href="/dogs/create">Create</a>
                    @endcan
                    {!! $grid !!}

                </div><!--card-body-->
            </div><!--card-->


        </div><!--col-->
    </div><!--row-->
@endsection


{{--
                    {{--                    <table class="table">--}}
{{--                        <tr>--}}
{{--                            <th style="width: 30%">Name</th>--}}
{{--                            <th style="width: 25%">Sire</th>--}}
{{--                            <th style="width:25%">Dam</th>--}}
{{--                            <th style="width:10%">Sex</th>--}}
{{--                            <th style="width:10%">Birth year</th>--}}
{{--                        </tr>--}}

{{--                        @foreach($dogs as $dog)--}}
{{--                            <tr>--}}

{{--                                <td><a href="/dogs/{{ $dog->id }}">{{ $dog->name }}</a></td>--}}
{{--                                @php--}}
{{--                                    $sire = $dog->father();--}}
{{--                                    $dam = $dog->mother() ;--}}
{{--                                @endphp--}}
{{--                                <td><a href="/dogs/{{ $sire->id ?? '#' }}">{{ $sire->name ?? '' }}</a></td>--}}
{{--                                <td><a href="/dogs/{{ $dam->id ?? '#' }}">{{ $dam->name ?? ''}}</a></td>--}}
{{--                                <td>{{ $dog->sex }}</td>--}}
{{--                                <td>{{ $dog->dob != null ? $dog->getBirthYear() : '' }}</td>--}}

{{--                            </tr>--}}
{{--                        @endforeach--}}
{{--                    </table>--}}
{{--                    <br>--}}
{{--                    <br>--}}
{{--                    {{$dogs->links()}}--}}
