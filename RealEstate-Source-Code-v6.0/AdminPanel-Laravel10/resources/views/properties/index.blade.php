@extends('layouts.master')

@section('content')

<div class="d-flex flex-row align-items-center">
    <h3>
        Properties
    </h3>
    <a class="btn btn-info btn-sm ml-auto" href="{{ route('properties.create') }}">Create Property</a>
</div>

<hr />

<table id="propertiesTable" class="table table-striped">
    <thead>
        <tr>
            <th>
                Featured
            </th>
            <th>
                Type
            </th>
            <th>
                Visibility
            </th>
            <th>
                Title
            </th>
            <th>
                Category
            </th>
            <th>
                Bed
            </th>
            <th>
                Bath
            </th>
            <th>
                Kitchen
            </th>
            <th>
                Parking
            </th>
            <th>
                Price
            </th>
            <th>
                City
            </th>
            <th>
                User
            </th>
            <th>
                Created Date
            </th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($properties as $item)
        <tr>
            <td>
                <input type="checkbox" disabled {{ filter_var($item->featured, FILTER_VALIDATE_BOOLEAN) ? 'checked' : '' }} />
            </td>
            <td>
                {{ $item->property_type->name }}
            </td>
            <td>
                {{ filter_var($item->visible, FILTER_VALIDATE_BOOLEAN) ? 'visible' : 'unvisible' }}
            </td>
            <td>
                {{ $item->title }}
            </td>
            <td>
                {{ $item->property_category->name }}
            </td>
            <td>
                {{ $item->bed_room_count }}
            </td>
            <td>
                {{ $item->bath_room_count }}
            </td>
            <td>
                {{ $item->kitchen_room_count }}
            </td>
            <td>
                {{ $item->parking_count }}
            </td>
            <td>
                {{ $item->currency . ' ' . $item->price }}
            </td>
            <td>
                {{ $item->city->name }}
            </td>
            <td>
                {{ $item->user->username }}
            </td>
            <td>
                {{ $item->created_at }}
            </td>
            <td>
                <a href="{{ route('properties.edit', $item->id) }}" class="btn btn-info btn-sm"><span data-feather="edit-2"></span></a>
                <a href="javascript:void(0);" data-entity-id="{{$item->id}}" class="btn btn-danger btn-sm delete-btn"><span data-feather="trash-2"></span></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@include('partials.delete_confirm_modal', ['actionName' => 'properties'])

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        createTable("#propertiesTable");
    });
</script>
@endpush
