@extends('layouts.master')

@section('content')

<h1>Create</h1>

<h4>Property Category</h4>
<hr />
<div class="row">
    <div class="col-md-4">
        <form action="{{ route('property_categories.store') }}" method="POST">
            {{ csrf_field() }}
            <div class="form-group">
                <label class="control-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required />
                <small class="text-validation-error text-danger">{{$errors->first('name')}}</small>
            </div>
            <div class="form-group">
                <input type="submit" value="Create" class="btn btn-primary" />
            </div>
        </form>
    </div>
</div>

<div>
    <a href="{{route('property_categories.index')}}">Back to List</a>
</div>

@endsection
