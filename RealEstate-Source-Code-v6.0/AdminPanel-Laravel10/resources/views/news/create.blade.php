@extends('layouts.master')

@section('content')

<h1>Create</h1>

<h4>News</h4>
<hr />
<div class="row">
    <div class="col-xl-12">
        <form action="{{route("news.store")}}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" id="image_name" name="image_name" value="{{ old('image_name') }}" />
            <div class="form-group">
                <label for="category_id" class="control-label">Category</label>
                <select name="category_id" class="form-control">
                    @foreach ($news_categories as $item)
                    <option value="{{ $item->id }}" {{ $item->id == old('category_id') ? "selected" : "" }}>
                        {{ $item->name }}
                    </option>
                    @endforeach
                </select>
                <small class="text-validation-error text-danger">{{$errors->first('category_id')}}</small>
            </div>
            <div class="form-group">
                <label for="title" class="control-label">Title</label>
                <input name="title" class="form-control" value="{{ old('title') }}" required />
                <small class="text-validation-error text-danger">{{$errors->first('title')}}</small>
            </div>
            <div class="form-group">
                <label for="content" class="control-label">Content</label>
                <textarea id="content" name="content" class="form-control textarea-editor">{{ old('content') }}</textarea>
                <small class="text-validation-error text-danger">{{$errors->first('content')}}</small>
            </div>
            <div class="form-group">
                <label class="control-label">News Photo</label>
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
    <a href="{{route('news.index')}}">Back to List</a>
</div>

@endsection

@push('scripts')
@include('partials.file_pond_scripts')
<script>
    $(document).ready(() => {
        $('.textarea-editor').summernote({
            height: 300
        });
        createFilePond("imageFile", "image_name");
    });
</script>
@endpush
