@extends('layouts.master')

@section('content')

<div class="d-flex flex-row align-items-center">
    <h3>
        News
    </h3>
    <a class="btn btn-info btn-sm ml-auto" href="/news/create">Create News</a>
</div>

<hr />

<table id="newsTable" class="table table-striped">
    <thead>
        <tr>
            <th>
                Title
            </th>
            <th>
                Category
            </th>
            <th></th>

        </tr>
    </thead>
    <tbody>
        @foreach ($news as $item)
        <tr>
            <td>
                {{$item->title}}
            </td>
            <td>
                {{$item->category->name}}
            </td>
            <td>
                <a href="{{ route('news.edit', $item->id) }}" class="btn btn-info btn-sm"><span data-feather="edit-2"></span></a>
                <a href="javascript:void(0);" data-entity-id="{{$item->id}}" class="btn btn-danger btn-sm delete-btn"><span data-feather="trash-2"></span></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@include('partials.delete_confirm_modal', ['actionName' => 'news'])

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        createTable("#newsTable");
    });
</script>
@endpush
