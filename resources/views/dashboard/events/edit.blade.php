@extends('layouts.dashboard')

@section('content')
    <h1>Update {{ $event->main_title }}</h1>
    <hr>
    {!! Form::model($event, ['method' => 'PATCH','route' => ['events.update', $event->id], 'files' => true, 'id' => 'edit-events-form']) !!}
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label>Main Title:</label>
                {!! Form::text('main_title', null, array('placeholder' => 'Main Title','class' => 'form-control')) !!}
            </div>
            <div class="form-group">
                <label>Secondary Title:</label>
                {!! Form::text('secondary_title', null, array('placeholder' => 'Secondary Title','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-sm-12 ">
            <div class="form-group">
                <label>Content:</label>
                {!! Form::textarea('content', null, array('placeholder' => 'Content goes here','class' => 'form-control', 'id'=>'editor')) !!}
            </div>
        </div>

        <div class="col-sm-12">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Invited users:</label>
                    {!! Form::select('visitors[]', $invited, null, ["data-placeholder"=>"Select invited Users ...",
                    'multiple', "class"=>"chosen-select", 'id' => 'get-invited']) !!}
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group" id="data_5">
                    <label class="font-normal">Range select</label>
                    <div class="input-daterange input-group" id="datepicker">
                        <div class='input-group date datetimepicker'>
                            {!! Form::text('start_date', $event->getAttributes()['start_date'] , array('class' => 'input-sm form-control')) !!}
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                        <span class="input-group-addon">to</span>
                        <div class='input-group date datetimepicker'>
                            {!! Form::text('end_date', $event->getAttributes()['end_date'], array('class' => 'input-sm form-control')) !!}
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="form-group">
                <label for="location">Location</label>
                {!! Form::text('location', null, array('class' => 'map-input form-control', 'id'=>'address-input')) !!}
                {!! Form::hidden('address_latitude', null, array('class' => 'input-sm form-control', 'id' => "address-latitude")) !!}
                {!! Form::hidden('address_longitude', null, array('class' => 'input-sm form-control', 'id'=>'address-longitude')) !!}
            </div>
            <div id="address-map-container" style="width:100%;height:400px;margin-bottom: 40px; ">
                <div style="width: 100%; height: 100%" id="address-map"></div>
            </div>
        </div>
        <div class="col-sm-12">
            <label for="document">Documents</label>
            <div class="dropzone" id="dropzone">

            </div>
        </div>
        <div class="col-sm-12 col-md-12 text-center">
            {!! Form::submit('Save Changes', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@push('dropzone-config')
    @include('includes/dropzone-script')
@endpush

@push('JSValidatorScript')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\EventRequest') !!}
@endpush

@push('googleMap-script')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize"
            async defer></script>
    <script src="{{ asset('js/mapInput.js') }}"></script>
@endpush

@push('ckeditor')
    <!-- ckeditor -->
    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
@endpush

