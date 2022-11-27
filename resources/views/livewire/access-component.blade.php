<div class="p-10">
    <x-header-modal>
        Access Permission
    </x-header-modal>

    <x-form-group caption="User">
        <select 
        wire:model="user_id" 
        wire:change="selectuser">
            <option value="">-- Pilih User --</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
        @error('user_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <div class="grid grid-cols-4 gap-4 mt-4">
        @foreach($permissions as $permission)
            <x-checkbox-group caption="{{ $permission->name }}" >
                <x-checkbox wire:model="selectedpermission.{{ $permission->id }}"/>
            </x-checkbox-group>
        @endforeach
    </div>

    <x-footer-modal>
        <x-secondary-button
            wire:click="cancel">
            Cancel
        </x-secondary-button>
        <x-button
            wire:click="save">
            Save
        </x-button>
    </x-footer-modal>
</div>
