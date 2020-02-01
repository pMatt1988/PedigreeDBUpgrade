{{--<form action='/dogs' method="POST">--}}


{{ html()->form($method, "/dogs/{$dog->id}")->class('form-horizontal')->attribute('autocomplete="off" enctype="multipart/form-data"')->open() }}

<div class="row">

    <div class="col-4">
        {{-- Image --}}
        <label for="image" class="col-form-label">Image</label>
        <div class="">
            <input id="image" name="image" type="file" class="form-control-file">
            @if($dog->image_url != null)
                <img src="{{'/storage/pedigree-img/' . $dog->image_url}}" alt="Dog Image" id="image-view"
                     class="img-fluid p-5">
            @else
                <img src="" alt="Dog Image" id="image-view" class="img-fluid p-5" hidden>
            @endif
        </div>
    </div>

    <div class="col">
        {{-- Name --}}
        <div class="form-group row">
            <label for="name" class="col-4 col-form-label">Name</label>
            <div class="col-8">
                <input id="name" name="name" type="text" class="form-control form-control-sm"
                       value="{{ old('name', $dog->name) }}">
            </div>
        </div>

        {{-- Sire --}}
        <div class="form-group row">
            <label for="sire" class="col-4 col-form-label">Sire</label>
            <div class="col-8">
                <input id="sire" name="sire" type="text" class="form-control form-control-sm"
                       value="{{ old('sire', $dog->father()->name ?? null) }}">
            </div>
        </div>

        {{-- Dam --}}
        <div class="form-group row">
            <label for="dam" class="col-4 col-form-label">Dam</label>
            <div class="col-8">
                <input id="dam" name="dam" type="text" class="form-control form-control-sm"
                       value="{{ old('dam', $dog->mother()->name ?? null) }}">
            </div>
        </div>


        {{-- Sex --}}
        <div class="form-group row">
            <label class="col-4">Sex</label>
            <div class="col-8">
                <div class="custom-control custom-radio custom-control-inline">
                    <input name="sex" id="sexMale" type="radio" class="custom-control-input form-control-sm"
                           value="male"
                        {{ (old('sex') === 'male' || $dog->sex === 'male' || $dog->sex === null) ? 'checked' : '' }}>
                    <label for="sexMale" class="custom-control-label">Male</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input name="sex" id="sexFemale" type="radio" class="custom-control-input form-control-sm"
                           value="female"
                        {{ (old('sex') == 'female' || $dog->sex == 'female') ? 'checked' : '' }}>
                    <label for="sexFemale" class="custom-control-label">Female</label>
                </div>
            </div>
        </div>

        {{-- Breeder --}}
        <div class="form-group row">
            <label for="breeder" class="col-4 col-form-label">Breeder</label>
            <div class="col-8">
                <input id="breeder" name="breeder" type="text" class="form-control form-control-sm"
                       value="{{ old('breeder', $dog->breeder) }}">
            </div>
        </div>

        {{-- Owner --}}
        <div class="form-group row">
            <label for="owner" class="col-4 col-form-label">Owner</label>
            <div class="col-8">
                <input id="owner" name="owner" type="text" class="form-control form-control-sm"
                       value="{{ old('owner', $dog->owner) }}">
            </div>
        </div>

        {{-- Date of Birth --}}
        <div class="form-group row">
            <label for="dob" class="col-4 col-form-label">Date of Birth</label>
            <div class="col-8">
                <input id="dob" name="dob" type="date" class="form-control form-control-sm"
                       value="{{ old('dob', ($dog->dob !== null) ? $dog->getDate() : null) }}">
            </div>
        </div>

        {{-- Pre Title --}}
        <div class="form-group row">
            <label for="pretitle" class="col-4 col-form-label">Pre-title</label>
            <div class="col-8">
                <input id="pretitle" name="pretitle" type="text" class="form-control form-control-sm"
                       value="{{ old('pretitle', $dog->pretitle) }}">
            </div>
        </div>


        {{-- Post Title --}}
        <div class="form-group row">
            <label for="posttitle" class="col-4 col-form-label">Post-title</label>
            <div class="col-8">
                <input id="posttitle" name="posttitle" type="text" class="form-control form-control-sm"
                       value="{{ old('posttitle', $dog->posttitle) }}">
            </div>
        </div>

        {{-- Registration Number --}}
        <div class="form-group row">
            <label for="reg" class="col-4 col-form-label">Registration Number</label>
            <div class="col-8">
                <input id="reg" name="reg" type="text" class="form-control form-control-sm"
                       value="{{ old('reg', $dog->reg) }}">
            </div>
        </div>

        {{-- Color --}}
        <div class="form-group row">
            <label for="color" class="col-4 col-form-label">Color</label>
            <div class="col-8">
                <input id="color" name="color" type="text" class="form-control form-control-sm"
                       value="{{ old('color', $dog->color) }}">
            </div>
        </div>

        {{-- Markings --}}
        <div class="form-group row">
            <label for="markings" class="col-4 col-form-label">Markings</label>
            <div class="col-8">
                <input id="markings" name="markings" type="text" class="form-control form-control-sm"
                       value="{{ old('markings', $dog->markings) }}">
            </div>
        </div>

        {{-- Website --}}
        <div class="form-group row">
            <label for="website" class="col-4 col-form-label">Website</label>
            <div class="col-8">
                <input id="website" name="website" type="text" class="form-control form-control-sm"
                       value="{{ old('website', $dog->website) }}">
            </div>
        </div>

        {{-- Submit --}}
        <div class="form-group row">
            <div class="offset-4 col-8">
                <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                <a href="/dogs" class="btn btn-danger">Cancel</a>
            </div>
        </div>


    </div>


</div>


{{ html()->form()->close() }}


@push('after-scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/typeahead.js') }}">
    </script>
    <script type="text/javascript">
        $('#sire').typeahead({
            minLength: 3,
            fitToElement: true,
            source: function (query, process) {
                $.get('/api/autocomplete/' + query + '/male', function (data) {
                    console.log(data);
                    return process(JSON.parse(data));
                });
            },
        })
    </script>

    <script type="text/javascript">
        $('#dam').typeahead({
            minLength: 3,
            fitToElement: true,
            source: function (query, process) {
                $.get('/api/autocomplete/' + query + '/female', function (data) {
                    console.log(data);
                    return process(JSON.parse(data));
                });
            },
        })
    </script>

    <script>
        $('#image').change();
    </script>
@endpush
