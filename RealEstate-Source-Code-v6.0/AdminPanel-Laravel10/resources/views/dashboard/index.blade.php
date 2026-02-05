@extends('layouts.master')

@section('content')

<h1 class="mt-2">Welcome, {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</h1>

<div class="row">
    <div class="col-lg-12 col-xl-6">
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title">Most Liked 10 Properties</h5>

                <table id="likedPropertiesTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>
                                Title
                            </th>
                            <th>
                                City
                            </th>
                            <th>
                                Likes
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($topList as $item)
                        <tr>
                            <td>
                                {{$item->propert_title}}
                            </td>
                            <td>
                                {{$item->city_name}}
                            </td>
                            <td>
                                {{$item->count}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
