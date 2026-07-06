<div>
    <x-header-modal>
        Input Penerimaan
    </x-header-modal>

    <x-form-group caption="Customer" class="mb-2">
        <livewire:customer.customer-select :deskripsi="$customer"/>
        @error('customer_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Invoice" class="mb-2">
        <livewire:penerimaan.invoice-select :noinvoice="$noinvoice" :customer_id="$customer_id" :key="'invoice-'.$customer_id"/>
        @error('invoice_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Tanggal" class="mb-2">
        <x-datepicker wire:model="tgl_penerimaan" id="tgl_penerimaan" name="tanggal"/>
        @error('tgl_penerimaan')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Nomor Bukti Potong" class="mb-2">
        <x-textbox wire:model="nobukti_potong" id="nobukti_potong" name="nobukti_potong"/>
        @error('nobukti_potong')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="PPh 23" class="mb-2">
        <x-number-text wire:model="jumlah" id="jumlah" name="jumlah" class="border-gray-300 focus:border-purple-400"/>
        @error('jumlah')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Keterangan" class="mb-2">
        <x-textbox wire:model="keterangan" id="keterangan" name="keterangan"/>
        @error('keterangan')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >Tutup</x-secondary-button>
        <x-button
            wire:loading.attr="disabled"
            wire:click="save">
            Save
        </x-button>
    </x-footer-modal>
</div>