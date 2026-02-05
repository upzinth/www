@extends('layouts.auth')

@section('content')

<form class="form-signin" method="POST" action="{{ route('login') }}">
    @csrf
    <img class="mb-3" src="/logo.png" alt="" width="300">
    <h1 class="h4 mb-4 font-weight-normal">Please sign in</h1>

    <label for="username" class="sr-only">Username</label>
    <input id="username" name="username" type="text" class="form-control" placeholder="Username" required autofocus />

    <label for="password" class="sr-only">Password</label>
    <input id="password" name="password" type="password" class="form-control" placeholder="Password" required />

    @error('username')
    <label class="text-danger">{{ $message }}</label>
    @enderror
    @error('password')
    <label class="text-danger">{{ $message }}</label>
    @enderror

    <button class="btn btn-lg btn-primary btn-block mt-4" type="submit">Sign in</button>
    <div class="mt-3">
        <a href="{{ route('password.request') }}">Forget Password</a>
    </div>

    <p class="mt-3 mb-3 text-muted">&copy; {{date("Y")}} Publ Realty</p>
</form>

@endsection
