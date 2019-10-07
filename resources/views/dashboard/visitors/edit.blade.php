@extends('layouts.dashboard')

@section('content')
    <h1>Edit {{$visitor->user->full_name}}</h1>
    <hr>
    {!! Form::model($visitor, array('route' => ['visitors.update', $visitor->id],'method'=>'PATCH', 'files' => true)) !!}
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>First Name:</label>
                {!! Form::text('first_name', $visitor->user->first_name, array('placeholder' => 'First Name','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Last Name:</label>
                {!! Form::text('last_name', $visitor->user->last_name, array('placeholder' => 'Last Name','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Email:</label>
                {!! Form::email('email', $visitor->user->email, array('placeholder' => 'Email','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Phone:</label>
                {!! Form::text('phone', $visitor->user->phone, array('placeholder' => 'Phone','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Country:</label>
                {{ Form::select('country_id', [0 => 'Select Country', $countries], $visitor->country_id, array('class' => 'form-control', 'id' => 'country')) }}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group" id="city-wrapper">
                <label>City:</label>
                {{ Form::select('city_id', [$visitor->city_id => $visitor->city->name], null, array('class' => 'form-control', 'id' => 'city')) }}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Gender:</label>
                {!! Form::select('gender', ['Male'=>'Male', 'Female'=>'Female'], $visitor->gender, array('placeholder' => 'Select Gender','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>{!! Form::radio('is_active' , 0, null, ['class'=>'i-checks']) !!} Inactive</label>
                <label>{!! Form::radio('is_active', 1, null, ['class'=>'i-checks']) !!} Active</label>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Image:</label>
                {!! Form::file('image', null, array('class' => 'form-control')) !!}
            </div>
        </div>
    </div>
    <div class="text-center">
        {!! Form::submit('Submit!', ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
@endsection

@push('ajax-get-cities')

    <script>
        $('#country').change(function(){
            let cid = $(this).val();
            if(cid){
                $.ajax({
                    type:"get",
                    url:" {{url('/getCities')}}/"+cid,
                    success:function(res){
                        if(res){
                            $('#city-wrapper').css('display', 'block')
                            $("#city").empty();
                            $("#city").append('<option value="">Select City</option>');
                            $.each(res, function(key, value){
                                $("#city").append('<option value="'+key+'">'+value+'</option>');
                            });
                        }
                    }
                });
            }
        });
    </script>

@endpush
