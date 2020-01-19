@extends('frontend.layouts.app')

@push('after-styles')
    <style>

        table {
            width: 100%;
            border-spacing: 0;
            border-collapse: inherit;
            background-color:white;
        }

        tr {
            background: white;
        }

        td {
            text-align: center;
            background: lightcoral;
            border: 1px solid;
        }
    </style>
@endpush

@section('title', app_name() . ' | ' . "Sample Table")

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>Sample Table</strong>
                </div><!--card-header-->
                <div class="card-body bg-danger">
                    <table id="main-table">
                        <tr>
                            <td>George</td>
                            <td>
                                <table>
                                    <tr>
                                        <td>George</td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td>George</td>
                                                </tr>
                                                <tr>
                                                    <td>Annie</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Annie</td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td>George</td>
                                                </tr>
                                                <tr>
                                                    <td>Annie</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                </div><!--card-body-->
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->
@endsection



