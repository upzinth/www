@extends('layouts.master')

@section('content')

<h1>Create</h1>

<h4>City</h4>
<hr />
<div class="row">
    <div class="col-md-12">
        <form action="{{route("cities.store")}}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" id="image_name" name="image_name" />
            <div class="form-group">
                <label class="control-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required />
                <small class="text-validation-error text-danger">{{$errors->first('name')}}</small>
            </div>
            <div class="form-group">
                <label class="control-label">City Image</label>
                <input id="imageFile" type="file" required />
                <small class="text-validation-error text-danger">{{$errors->first('image_name')}}</small>
            </div>
            <div class="form-group">
                <input type="submit" value="Create" class="btn btn-primary" />
            </div>
        </form>
    </div>
</div>

<div>
    <a href="{{route('cities.index')}}">Back to List</a>
</div>

@endsection

@push('scripts')
@include('partials.file_pond_scripts')
<script>
    $(document).ready(() => {
        createFilePond("imageFile", "image_name");
    });
</script>
@endpush
