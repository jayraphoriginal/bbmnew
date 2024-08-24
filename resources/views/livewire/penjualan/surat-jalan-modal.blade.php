<div>
    <x-header-modal>
        Input Surat Jalan
    </x-header-modal>

    <div class="xl:flex lg:flex  xl:gap-4 lg:gap-4">
        <div class="lg:w-1/2">
        <x-form-group caption="Jam Pengiriman">
                <x-datepicker
                    wire:model="suratjalan.tgl_pengiriman"
                />
                @error('suratjalan.tgl_pengiriman')
                    <x-error-form>{{ $message }}</x-error-form>
                @enderror
            </x-form-group>
            <x-form-group caption="Tujuan">
                <x-textbox
                    wire:model="suratjalan.tujuan"
                />
                @error('suratjalan.tujuan')
                <x-error-form>{{ $message }}</x-error-form>
                @enderror
            </x-form-group>
        </div>
        <div class="lg:w-1/2">
            <x-form-group caption="Nomor Polisi">
                <x-textbox
                    wire:model="suratjalan.nopol"
                />
                @error('suratjalan.nopol')
                <x-error-form>{{ $message }}</x-error-form>
                @enderror
            </x-form-group>
            <x-form-group caption="Driver">
                <x-textbox
                    wire:model="suratjalan.driver"
                />
                @error('suratjalan.driver')
                <x-error-form>{{ $message }}</x-error-form>
                @enderror
            </x-form-group>
        </div>
    </div>

    <livewire:penjualan.tmp-suratjalan-table m_penjualan_id="{{$m_penjualan_id}}"/>
   
    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >Tutup</x-secondary-button>
        <x-button
            wire:click="save">
            Save
         </x-button>
    </x-footer-modal>
</div>
