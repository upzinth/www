@extends('layouts.master')

@section('content')

<div class="d-flex flex-row align-items-center">
    <h3>
        Property Categories
    </h3>
    <a class="btn btn-info btn-sm ml-auto" href="/property_categories/create">Create Category</a>
</div>

<hr />

<table id="propertyCategoriesTable" class="table table-striped">
    <thead>
        <tr>
            <th>
                Name
            </th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($propertyCategories as $item)
        <tr>
            <td>
                {{$item->name}}
            </td>
            <td>
                <a href="{{ route('property_categories.edit', $item->id) }}" class="btn btn-info btn-sm"><span data-feather="edit-2"></span></a>
                <a href="javascript:void(0);" data-entity-id="{{$item->id}}" class="btn btn-danger btn-sm delete-btn"><span data-feather="trash-2"></span></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@include('partials.delete_confirm_modal', ['actionName' => 'property_categories'])

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        createTable("#propertyCategoriesTable");
    });
</script>
@endpush
