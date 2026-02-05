@extends('layouts.master')

@section('content')

<h1>Edit</h1>

<h4>News Category</h4>
<hr />
<div class="row">
    <div class="col-md-4">
        <form action="{{ route('news_categories.update', $newsCategory->id) }}" method="POST">
            {{ csrf_field() }}
            @method('PUT')
            <div class="form-group">
                <label class="control-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $newsCategory->name) }}" required />
                <small class="text-validation-error text-danger">{{$errors->first('name')}}</small>
            </div>
            <div class="form-group">
                <input type="submit" value="Save" class="btn btn-primary" />
            </div>
        </form>
    </div>
</div>

<div>
    <a href="{{route('news_categories.index')}}">Back to List</a>
</div>

@endsection
