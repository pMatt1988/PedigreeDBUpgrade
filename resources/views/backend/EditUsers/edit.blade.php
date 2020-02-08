@extends('adminlte::page');


@section('content')
    <div class="container">

        <h1>User: {{ $user->email }}</h1>

        <div class="card">
            <div class="card-header bg-primary">
                Roles:
            </div>
            <div class="card-body">
                <form action="/backend/users/{{$user->id}}" method="POST">
                    @csrf
                    @foreach($roles as $role)
                        <div class="row">
                            <div class="col-3">
                                <label class="form-check-label" for="{{ $role->name }}">{{ $role->name }}</label>
                            </div>
                            <div class="col">
                                <input class="form-check-input" name="{{ $role->name }}"
                                       type="checkbox" {{ $user->hasRole($role) ? 'checked' : '' }}>
                            </div>
                        </div>
                    @endforeach
                    <div class="my-4">
                        <button type="submit" class="btn btn-success">Save</button>
                        <a class="btn btn-danger text-white" href="/backend/users">Cancel</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-primary">
                Dogs:
            </div>
            <div class="card-body">
                {!! $grid !!}
            </div>
        </div>
    </div>
@endsection
