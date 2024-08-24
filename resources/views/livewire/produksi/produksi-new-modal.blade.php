<div>
    <x-header-modal>
        Input Produksi
    </x-header-modal>

    <x-form-group caption="Tanggal">
        <x-datepicker
            wire:model="tanggal"
        />
        @error('tanggal')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>


    <x-form-group caption="Barang Jadi">
        <livewire:produk-turunan.produk-turunan-select :deskripsi="$deskripsi" />
        @error('barang_id')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <div class="xl:flex lg:flex  xl:gap-4 lg:gap-4">
        <div class="lg:w-1/2">

            <x-form-group caption="Jumlah">
                <x-number-text
                    wire:model="jumlah"/>
                @error('jumlah')
                    <x-error-form>{{ $message }}</x-error-form>
                @enderror
            </x-form-group>

            <x-form-group caption="Ticket Produksi">
                <livewire:produksi.ticket-select :deskripsi="$ticket" />
                @error('ticket_id')
                    <x-error-form>{{ $message }}</x-error-form>
                @enderror
            </x-form-group>
        </div>
        <div class="lg:w-1/2">
            <x-form-group caption="Satuan">
                <x-textbox
                    readonly
                    wire:model="satuan"
                />
                @error('satuan_id')
                    <x-error-form>{{ $message }}</x-error-form>
                @enderror
            </x-form-group>

            <x-form-group caption="Kubikasi Terpakai di Ticket">
                <x-number-text
                    wire:model="jumlah_ticket"/>
                @error('jumlah_ticket')
                    <x-error-form>{{ $message }}</x-error-form>
                @enderror
            </x-form-group>
        </div> 
    </div>

    <x-form-group caption="Keterangan">
        <x-textbox
            wire:model="keterangan"
        />
        @error('keterangan')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-button
        class="mt-2"
        wire:click.prevent="$emit('openModal', 'produksi.produksi-biaya-modal')">
        Tambah Biaya
    </x-button>

    <livewire:produksi.tmp-biaya-produksi-table/>      

    <x-button
        class="mt-2"
        wire:click.prevent="$emit('openModal', 'produksi.produksi-detail-modal')">
        Tambah Detail
    </x-button>
    
    <x-button
        class="mt-2"
        wire:click.prevent="insertkomposisi">
        Komposisi
    </x-button>

    <livewire:produksi.tmp-produksi-table/>      

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >Cancel</x-secondary-button>
        <x-button
            wire:loading.attr="disabled"
            wire:click="save">
            Save
         </x-button>
    </x-footer-modal>
</div>
