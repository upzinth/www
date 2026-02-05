@extends('layouts.master')

@section('content')

<h1>Edit</h1>

<h4>User</h4>
<hr />
<div class="row">
    <div class="col-lg-6">
        <form action="{{ route("users.update", $user->id) }}" method="POST">
            {{ csrf_field() }}
            @method('PUT')

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label class="control-label">First Name</label>
                        <input class="form-control" name="first_name" value="{{ old('first_name', $user->first_name) }}" />
                        @if ($errors->has('first_name'))
                        <small class="text-validation-error text-danger">{{$errors->first('first_name')}}</small>
                        @endif
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="control-label">Last Name</label>
                        <input class="form-control" name="last_name" value="{{ old('last_name', $user->last_name) }}" />
                        <small class="text-validation-error text-danger">{{$errors->first('last_name')}}</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label class="control-label">Phone Number</label>
                        <input class="form-control" type="tel" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" />
                        <small class="text-validation-error text-danger">{{$errors->first('phone_number')}}</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="control-label">Email</label>
                        <input class="form-control" type="email" name="email" value="{{ old('email', $user->email) }}" />
                        <small class="text-validation-error text-danger">{{$errors->first('email')}}</small>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Username</label>
                <input class="form-control" name="username" value="{{ old('username', $user->username) }}" />
                <small class="text-validation-error text-danger">{{$errors->first('username')}}</small>
            </div>
            <div class="form-group">
                <label class="control-label">Address</label>
                <input class="form-control" name="address" value="{{ old('address', $user->address) }}" />
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label class="control-label">Latitude</label>
                        <input class="form-control" name="latitude" value="{{ old('latitude', $user->latitude) }}" />
                        <small class="text-validation-error text-danger">{{$errors->first('latitude')}}</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="control-label">Longitude</label>
                        <input class="form-control" name="longitude" value="{{ old('longitude', $user->longitude) }}" />
                        <small class="text-validation-error text-danger">{{$errors->first('longitude')}}</small>
                    </div>
                </div>
            </div>
            <input type="submit" value="Save" class="btn btn-primary" />
        </form>
    </div>
</div>

@endsection
