@extends('frontend.layouts.app')

@push('after-styles')
    <style>

        table {
            border-collapse: collapse;
            width: 100%;

        }

        td {
            padding:8px;
            text-align: center;
            border: 1px solid;
            background-color: purple;
            color: silver;
        }
        td:hover {
            background-color: silver !important;
        }
        td a {
            display: block;
            height: 100%;
            width: 100%;
            color: black;
        }
        td a:hover {
            text-decoration: none;
        }
    </style>
@endpush

@section('title', app_name() . ' | ' . "Testmate")

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>Pedigree</strong>
                </div><!--card-header-->
                <div class="card-body">
                    <?php echo $output ?>
                </div><!--card-body-->
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->
@endsection
