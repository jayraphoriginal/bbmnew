<div>
    <x-header-modal>
        Input Jurnal Manual
    </x-header-modal>
    <div class="xl:flex lg:flex  xl:gap-4 lg:gap-4">
        <div class="lg:w-1/2">
        <x-form-group caption="Tanggal">
            <x-datepicker
                wire:model="jurnalmanual.tanggal"/>
            @error('jurnalmanual.tanggal')
                <x-error-form>{{ $message }}</x-error-form>
            @enderror
        </x-form-group>
        </div>
    </div>
    <x-form-group caption="Keterangan">
        <x-textbox
            wire:model="jurnalmanual.keterangan"/>
        @error('jurnalmanual.keterangan')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>
   
    <x-button
    class="mt-2"
    wire:click.prevent="$emit('openModal', 'jurnal.jurnal-manual-detail-modal')"
    >Tambah Detail</x-button>

    <livewire:jurnal.tmp-jurnal-manual-table/>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')">
            Cancel
        </x-secondary-button>
        <x-button
            wire:click="save">
            Save
        </x-button>
    </x-footer-modal>
</div>
