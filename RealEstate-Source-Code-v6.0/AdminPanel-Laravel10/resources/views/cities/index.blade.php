@extends('layouts.master')

@section('content')

<div class="d-flex flex-row align-items-center">
    <h3>
        Cities
    </h3>
    <a class="btn btn-info btn-sm ml-auto" href="/cities/create">Create City</a>
</div>

<hr />

<table id="citiesTable" class="table table-striped">
    <thead>
        <tr>
            <th>
                Image
            </th>
            <th>
                Name
            </th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cities as $item)
        <tr>
            <td style="width: 130px">
                <img src="{{ url('/uploadfiles/images/'.$item->image_name) }}" class="img-thumbnail" />
            </td>
            <td>
                {{$item->name}}
            </td>
            <td>
                <a href="{{ route('cities.edit', $item->id) }}" class="btn btn-info btn-sm"><span data-feather="edit-2"></span></a>
                <a href="javascript:void(0);" data-entity-id="{{$item->id}}" class="btn btn-danger btn-sm delete-btn"><span data-feather="trash-2"></span></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@include('partials.delete_confirm_modal', ['actionName' => 'cities'])

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        createTable("#citiesTable");
    });
</script>
@endpush
