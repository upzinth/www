@extends('layouts.master')

@section('content')

<form action="{{ route('settings') }}" method="POST">
    {{ csrf_field() }}

    <div class="row">
        @if ($user->is_admin)
        <div class="col-lg-6">
            <h3>
                App Settings
            </h3>
            <hr />
            <input type="hidden" id="header_images" name="app_settings_header_images" value="{{ old('app_settings_header_images', $app_settings->header_images) }}" />
            <div class="form-group">
                <label class="control-label">E-Mail</label>
                <input class="form-control" name="app_settings_email" value="{{ old('app_settings_email', $app_settings->email) }}" />
                @if ($errors->has('app_settings_email'))
                <small class="text-validation-error text-danger">{{$errors->first('app_settings_email')}}</small>
                @endif
            </div>
            <div class="form-group">
                <label class="control-label">Web Site</label>
                <input class="form-control" name="app_settings_website" value="{{ old('app_settings_website', $app_settings->website) }}" />
                @if ($errors->has('app_settings_website'))
                <small class="text-validation-error text-danger">{{$errors->first('app_settings_website')}}</small>
                @endif
            </div>
            <div class="form-group">
                <label class="control-label">App Version</label>
                <input class="form-control" name="app_settings_app_version" value="{{ old('app_settings_app_version', $app_settings->app_version) }}" />
            </div>
            <div class="form-group">
                <label class="control-label">About US</label>
                <textarea class="form-control textarea-editor" name="app_settings_about_us">{{ old('app_settings_about_us', $app_settings->about_us) }}</textarea>
            </div>
            <div class="form-group">
                <label class="control-label">Privacy Policy</label>
                <textarea class="form-control textarea-editor" name="app_settings_privacy_policy">{{ old('app_settings_privacy_policy', $app_settings->privacy_policy) }}</textarea>
            </div>
            <div class="form-group">
                <label class="control-label">User Terms</label>
                <textarea class="form-control textarea-editor" name="app_settings_user_terms">{{ old('app_settings_user_terms', $app_settings->user_terms) }}</textarea>
            </div>
            <div class="form-group">
                <label class="control-label">App Header Images</label>
                <input id="inputHeaderImages" type="file" multiple />
            </div>
            <div class="form-group">
                <label class="control-label">Facebook Url</label>
                <input class="form-control" name="app_settings_facebook_url" value="{{ old('app_settings_facebook_url', $app_settings->facebook_url) }}" />
            </div>
            <div class="form-group">
                <label class="control-label">Twitter Url</label>
                <input class="form-control" name="app_settings_twitter_url" value="{{ old('app_settings_twitter_url', $app_settings->twitter_url) }}" />
            </div>
            <div class="form-group">
                <label class="control-label">Youtube Url</label>
                <input class="form-control" name="app_settings_youtube_url" value="{{ old('app_settings_youtube_url', $app_settings->youtube_url) }}" />
            </div>
            <div class="form-group">
                <label class="control-label">Instagram Url</label>
                <input class="form-control" name="app_settings_instagram_url" value="{{ old('app_settings_instagram_url', $app_settings->instagram_url) }}" />
            </div>
        </div>
        @endif

        <div class="col-lg-6">
            <h3>
                User Settings
            </h3>
            <hr />
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label class="control-label">First Name</label>
                        <input class="form-control" name="user_first_name" value="{{ old('user_first_name', $user->first_name) }}" />
                        @if ($errors->has('user_first_name'))
                        <small class="text-validation-error text-danger">{{$errors->first('user_first_name')}}</small>
                        @endif
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="control-label">Last Name</label>
                        <input class="form-control" name="user_last_name" value="{{ old('user_last_name', $user->last_name) }}" />
                        @if ($errors->has('user_last_name'))
                        <small class="text-validation-error text-danger">{{$errors->first('user_last_name')}}</small>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label class="control-label">Phone Number</label>
                        <input class="form-control" type="tel" name="user_phone_number" value="{{ old('user_phone_number', $user->phone_number) }}" />
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="control-label">Email</label>
                        <input class="form-control" type="email" name="user_email" value="{{ old('user_email', $user->email) }}" />
                        <small class="text-validation-error text-danger">{{$errors->first('user_email')}}</small>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Username</label>
                <input class="form-control" name="user_username" value="{{ old('user_username', $user->username) }}" />
                @if ($errors->has('user_username'))
                <small class="text-validation-error text-danger">{{$errors->first('user_username')}}</small>
                @endif
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label class="control-label">New Password</label>
                        <input class="form-control" name="user_new_password" type="password" />
                        @if ($errors->has('user_new_password'))
                        <small class="text-validation-error text-danger">{{$errors->first('user_new_password')}}</small>
                        @endif
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="control-label">New Password Again</label>
                        <input class="form-control" name="user_new_password_again" type="password" />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Address</label>
                <input class="form-control" name="user_address" value="{{ old('user_address', $user->address) }}" />
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label class="control-label">Latitude</label>
                        <input class="form-control" name="user_latitude" value="{{ old('user_latitude', $user->latitude) }}" />
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="control-label">Longitude</label>
                        <input class="form-control" name="user_longitude" value="{{ old('user_longitude', $user->longitude) }}" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="submit" value="Save" class="btn btn-primary" />
</form>

@endsection

@push('scripts')
@include('partials.file_pond_scripts')
<script>
    $(document).ready(() => {
        $('.textarea-editor').summernote({
            height: 300
        });
        createFilePond("inputHeaderImages", "header_images");
    });
</script>
@endpush
