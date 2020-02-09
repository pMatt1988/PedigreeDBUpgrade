@extends('adminlte::page');

@section('content')
    <div class="container">
        @php
            foreach ($history as $entry) {
                $model = json_decode($entry->model);

                echo "<div>{$model->name} {$entry->created_at}</div>";
            }
        @endphp
    </div>
@endsection
