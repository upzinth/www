<x-install-layout>
    <p class="mb-24">@lang('install.welcome', ['name' => config('app.name')])</p>
    <p class="mb-24">@lang('install.intro_text')</p>
    <ol class="mb-24 list-decimal list-inside">
        <li>@lang('install.db_host')</li>
        <li>@lang('install.db_name')</li>
        <li>@lang('install.db_username')</li>
        <li>@lang('install.db_password')</li>
    </ol>
    <p class="mb-24">@lang('install.help_text')</p>
    <p>@lang('install.installer_info')</p>
    <p>@lang('install.need_help') <a class="text-primary underline hover:text-primary-dark"
            href="https://support.vebto.com/hc/articles/35/37/34/installation"
            target="_blank">@lang('install.guide_link')</a></p>
    <x-install-button :href="url('install/requirements')">@lang('install.continue')</x-install-button>
</x-install-layout>