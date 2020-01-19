@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . "Testmate")

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>Pedigree</strong>
                </div><!--card-header-->
                <div class="card-body">
                    <form action="/testmate/show" method="GET" autocomplete="off">
                        <div class="form-group">
                            <label for="sire">Sire: </label>
                            <input type="text" id="sire" name="sire" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="dam">Dam: </label>
                            <input type="text" id="dam" name="dam" class="form-control">
                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

                    </form>
                </div><!--card-body-->
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->
@endsection

@push('after-scripts')
    {{ script('js/typeahead.js') }}

    <script type="text/javascript">
        let lastSire = null;
        let lastDam = null;

        $('#sire').typeahead({
            minLength: 3,
            fitToElement: true,
            source: function (query, process) {
                $.get('../../autocomplete/' + query + '/male', function (data) {
                    return process(JSON.parse(data));
                });
            },
        });
        $('#dam').typeahead({
            minLength: 3,
            fitToElement: true,
            source: function (query, process) {
                $.get('../../autocomplete/' + query + '/female', function (data) {
                    let jData = JSON.parse(data);
                    console.log(jData);
                    return process(jData);
                });
            },
        });
    </script>


@endpush
