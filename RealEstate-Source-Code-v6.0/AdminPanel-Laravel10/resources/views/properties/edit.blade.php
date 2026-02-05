@extends('layouts.master')

@section('content')

<h1>Edit</h1>

<h4>Property</h4>
<hr />
<div class="row">
    <div class="col-xl-12">
        <form action="{{route("properties.update", $property->id)}}" method="POST">
            {{ csrf_field() }}
            @method('PUT')
            <input type="hidden" id="image_names" name="image_names" value="{{ old('image_names', $property->image_names) }}" />

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label">Type</label>
                        <select name="property_type_id" class="form-control">
                            @foreach ($property_types as $item)
                            <option value="{{ $item->id }}" {{ $item->id == old('property_type_id', $property->property_type_id) ? "selected" : "" }}>
                                {{ $item->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label">Category</label>
                        <select name="property_category_id" class="form-control">
                            @foreach ($property_categories as $item)
                            <option value="{{ $item->id }}" {{ $item->id == old('property_category_id', $property->property_category_id) ? "selected" : "" }}>
                                {{ $item->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label">City</label>
                        <select name="city_id" class="form-control">
                            @foreach ($cities as $item)
                            <option value="{{ $item->id }}" {{ $item->id == old('city_id', $property->city_id) ? "selected" : "" }}>
                                {{ $item->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label">Agent</label>
                        @if (Auth::user()->is_admin)
                        <select name="user_id" class="form-control">

                            @foreach ($users as $item)
                            <option value="{{ $item->id }}" {{ $item->id == old('user_id', $property->user_id) ? "selected" : "" }}>
                                {{ $item->first_name . ' ' . $item->last_name }}
                            </option>
                            @endforeach
                        </select>
                        @else
                        <select name="user_id" class="form-control" disabled>
                            <option value="{{ Auth::user()->id }}">
                                {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                            </option>
                        </select>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label">Title</label>
                        <input name="title" class="form-control" value="{{ old('title', $property->title) }}" required />
                        <small class="text-validation-error text-danger">{{$errors->first('title')}}</small>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group form-check mt-4">
                        <label class="form-check-label">
                            <input name="featured" type="checkbox" {{ filter_var(old('featured', $property->featured), FILTER_VALIDATE_BOOLEAN) ? "checked" : "" }} class="form-check-input" /> Featured
                        </label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group form-check mt-4">
                        <label class="form-check-label">
                            <input name="visible" type="checkbox" {{ filter_var(old('visible', $property->visible), FILTER_VALIDATE_BOOLEAN) ? "checked" : "" }} class="form-check-input" /> Visible
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Description</label>
                <textarea id="description" name="description" class="form-control textarea-editor">{{ old('description', $property->description) }}</textarea>
                <small class="text-validation-error text-danger">{{$errors->first('description')}}</small>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label">Bed Rooms</label>
                        <input name="bed_room_count" type="number" class="form-control" value="{{ old('bed_room_count', $property->bed_room_count) }}" required />
                        <small class="text-validation-error text-danger">{{$errors->first('bed_room_count')}}</small>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label">Bath Rooms</label>
                        <input name="bath_room_count" type="number" class="form-control" value="{{ old('bath_room_count', $property->bath_room_count) }}" required />
                        <small class="text-validation-error text-danger">{{$errors->first('bath_room_count')}}</small>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label">Kitchen Rooms</label>
                        <input name="kitchen_room_count" type="number" class="form-control" value="{{ old('kitchen_room_count', $property->kitchen_room_count) }}" required />
                        <small class="text-validation-error text-danger">{{$errors->first('kitchen_room_count')}}</small>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label">Parkings</label>
                        <input name="parking_count" type="number" class="form-control" value="{{ old('parking_count', $property->parking_count) }}" required />
                        <small class="text-validation-error text-danger">{{$errors->first('parking_count')}}</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-2">
                    <div class="form-group">
                        <label class="control-label">Size</label>
                        <input name="size" type="number" class="form-control" value="{{ old('size', $property->size) }}" required />
                        <small class="text-validation-error text-danger">{{$errors->first('size')}}</small>
                    </div>
                </div>
                <div class="col-sm-12 col-md-8 col-lg-10">
                    <div class="form-group">
                        <label class="control-label">Additional Features</label>
                        <input name="additional_features" class="form-control" value="{{ old('additional_features', $property->additional_features) }}" placeholder="Air Condition, Internet, Example" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-2">
                    <div class="form-group">
                        <label class="control-label">Currency</label>
                        <select name="currency" class="form-control">
                            @foreach (array('₺', '$', '£') as $item)
                            <option value="{{ $item }}" {{ $item == old('currency', $property->currency) ? "selected" : "" }}>
                                {{ $item }}
                            </option>
                            @endforeach
                        </select>
                        <small class="text-validation-error text-danger">{{$errors->first('currency')}}</small>
                    </div>
                </div>
                <div class="col-sm-12 col-md-8 col-lg-10">
                    <div class="form-group">
                        <label class="control-label">Price</label>
                        <input name="price" type="number" step="0.01" class="form-control" value="{{ old('price', $property->price) }}" required />
                        <small class="text-validation-error text-danger">{{$errors->first('price')}}</small>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Address</label>
                <input name="address" class="form-control" value="{{ old('address', $property->address) }}" required />
                <small class="text-validation-error text-danger">{{$errors->first('address')}}</small>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label">Latitude</label>
                        <input name="latitude" type="number" step="any" class="form-control" value="{{ old('latitude', $property->latitude) }}" required />
                        <small class="text-validation-error text-danger">{{$errors->first('latitude')}}</small>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label">Longitude</label>
                        <input name="longitude" type="number" step="any" class="form-control" value="{{ old('longitude', $property->longitude) }}" required />
                        <small class="text-validation-error text-danger">{{$errors->first('longitude')}}</small>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Property Images</label>
                <input id="inputPropertyImages" type="file" required multiple />
                <small class="text-validation-error text-danger">{{$errors->first('image_names')}}</small>
            </div>
            <div class="form-group">
                <input type="submit" value="Save" class="btn btn-primary" />
            </div>
        </form>
    </div>
</div>

<div>
    <a href="{{route('properties.index')}}">Back to List</a>
</div>

@endsection

@push('scripts')
@include('partials.file_pond_scripts')
<script>
    $(document).ready(() => {
        $('.textarea-editor').summernote({
            height: 300
        });
        createFilePond("inputPropertyImages", "image_names");
    });
</script>
@endpush
