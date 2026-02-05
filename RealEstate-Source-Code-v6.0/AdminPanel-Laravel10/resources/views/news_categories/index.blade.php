@extends('layouts.master')

@section('content')

<div class="d-flex flex-row align-items-center">
    <h3>
        News Categories
    </h3>
    <a class="btn btn-info btn-sm ml-auto" href="{{ route('news_categories.create') }}">Create News Category</a>
</div>

<hr />

<table id="newsCategoriesTable" class="table table-striped">
    <thead>
        <tr>
            <th>
                Name
            </th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($newsCategories as $item)
        <tr>
            <td>
                {{$item->name}}
            </td>
            <td>
                <a href="{{ route('news_categories.edit', $item->id) }}" class="btn btn-info btn-sm"><span data-feather="edit-2"></span></a>
                <a href="javascript:void(0);" data-entity-id="{{$item->id}}" class="btn btn-danger btn-sm delete-btn"><span data-feather="trash-2"></span></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@include('partials.delete_confirm_modal', ['actionName' => 'news_categories'])

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        createTable("#newsCategoriesTable");
    });
</script>
@endpush
