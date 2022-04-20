<x-app-layout>

    <x-actions-bar></x-actions-bar>

    <x-create-form :model="''">

        @include('partials.menu-settings')

            <form action="{{ route('settings.update') }}"  method="POST">
                @csrf
                @method('PATCH')
                
                <h1 class="text-center">Settings</h1>

                @if (session()->has('success'))
                    <x-alert :type="'success'" message="{{ session('success') }}" />
                @endif

                <h2>Security</h2>
                
                @foreach($settings as $setting)

                    @if($setting->key === 'allow-public-access')
                    <x-setting-box :title="'Allow Public Access'" :type="'checkbox'" :name="'setting[allow-public-access]'" value="{{ $setting->value }}">
                        Enabling this option will allow visitors, that are not logged-in, to access content in your GiGaWiki instance.
                    </x-setting-box>
                    @endif
                    
                    @if($setting->key === 'disable-comments')
                    <x-setting-box :title="'Disable Comments'" :type="'checkbox'" :name="'setting[disable-comments]'" value="{{ $setting->value }}">
                        Disables comments across all pages in the application. Existing comments are not shown.
                    </x-setting-box>
                    @endif
                    
                    @if($setting->key === 'enable-registration')
                    <x-setting-box :title="'Enable Registration'" :type="'checkbox'" :name="'setting[enable-registration]'" value="{{ $setting->value }}">
                        When registration is enabled user will be able to sign themselves up as an application user. 
                        Upon registration they are given a single, default user role.
                    </x-setting-box>
                    @endif

                    @if($setting->key === 'email-confirmation')
                    <x-setting-box :title="'Email Confirmation'" :type="'checkbox'" :name="'setting[email-confirmation]'" value="{{ $setting->value }}">
                        If domain restriction is used then email confirmation will be required and this option will be ignored.
                    </x-setting-box>
                    @endif

                @endforeach
                
                <div class="mt-4 text-right">
                    <x-button>Save Settings</x-button>
                </div>

            </form>

    </x-create-form>
    <x-toolbar />

</x-app-layout>