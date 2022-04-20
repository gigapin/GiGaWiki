<x-app-layout>

    <x-actions-bar></x-actions-bar>

    <x-create-form :model="''">

        @include('partials.menu-settings')

            <x-setting-box :title="'Open Recycle Bin'" :type="''" :name="''" :value="'Open Recycle Bin'" link="{{ route('settings.recycle-bin') }}">
                Deleted shelves, books, chapters & pages are sent to the recycle bin so they can be restored or permanently deleted.
                Older items in the recycle bin may be automatically removed after a while depending on system configuration.
            </x-setting-box>

            <x-setting-box :title="'Cleanup Images'" :type="''" :name="''" :value="'Cleanup Images'" link="{{ route('settings.delete-images') }}">
                Scans page & revision content to check which images and drawings are currently in use and which images are redundant.
                Ensure you create a full database and image backup before running this.
            </x-setting-box>

    </x-create-form>

    <x-toolbar />
    
</x-app-layout>
