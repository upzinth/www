@extends('layouts.master')

@section('content')

<div class="d-flex flex-row align-items-center">
    <h3>
        Users
    </h3>
</div>

<hr />

<table id="usersTable" class="table table-striped">
    <thead>
        <tr>
            <th>
                FirstName
            </th>
            <th>
                LastName
            </th>
            <th>
                PhoneNumber
            </th>
            <th>
                Email
            </th>
            <th>
                Username
            </th>
            <th>
                IsAdmin
            </th>
            <th>
                IsAgent
            </th>
            <th>
                Address
            </th>
            <th>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $item)
        <tr>
            <td>
                {{ $item->first_name }}
            </td>
            <td>
                {{ $item->last_name }}
            </td>
            <td>
                {{ $item->phone_number }}
            </td>
            <td>
                {{ $item->email }}
            </td>
            <td>
                {{ $item->username }}
            </td>
            <td>
                <input type="checkbox" {{ Auth::user()->id == $item->id ? 'disabled' : '' }} {{ $item->is_admin ? 'checked' : '' }} onclick="handleChecked('admin', this, {{ $item->id }});" />
            </td>
            <td>
                <input type="checkbox" {{ $item->is_agent ? 'checked' : '' }} onclick="handleChecked('agent', this, {{ $item->id }});" />
            </td>
            <td>
                {{ $item->address }}
            </td>
            <td>
                <a href="{{ route('users.edit', $item->id) }}" class="btn btn-info btn-sm"><span data-feather="edit-2"></span></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        createTable("#usersTable");
    });

    function handleChecked(role, cb, id) {

        $.ajax({
            type: "POST",
            url: "/users/update_role",
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            dataType: 'json',
            data: {
                role: role,
                userId: id,
                isChecked: cb.checked
            },
            success: () => {}
        })
    }
</script>
@endpush
