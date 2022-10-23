<div>
    <x-header-modal>
        Input Penjualan
    </x-header-modal>

    <div class="xl:flex lg:flex  xl:gap-4 lg:gap-4">
        <div class="lg:w-1/2">
            <x-form-group caption="Tanggal Jual">
                <x-datepicker
                    wire:model="MPenjualan.tgl_penjualan"
                />
                @error('MPenjualan.tgl_penjualan')
                <x-error-form>{{ $message }}</x-error-form>
                @enderror
            </x-form-group>
            <x-form-group caption="Customer">
                <livewire:customer.customer-select :deskripsi="$customer"/>
                @error('MPenjualan.customer_id')
                <x-error-form>{{ $message }}</x-error-form>
                @enderror
            </x-form-group>
            <x-form-group caption="Pembayaran">
                <x-combobox
                    wire:model="MPenjualan.pembayaran"
                >
                    <option value="">-- Isi Pembayaran --</option>
                    <option value="Dimuka">Dimuka</option>
                    <option value="Dimuka Full">Dimuka Full</option>
                    <option value="Diakhir">Diakhir</option>
                    <option value="Waktu Tagihan">Waktu Tagihan</option>
                </x-combobox>
                @error('MPenjualan.pembayaran')
                <x-error-form>{{ $message }}</x-error-form>
                @enderror
            </x-form-group>
            <x-form-group caption="Jenis Pembayaran">
                <x-combobox
                    wire:model="MPenjualan.jenis_pembayaran"
                >
                    <option value="">-- Isi Jenis Pembayaran --</option>
                    <option value="Tunai">Tunai</option>
                    <option value="Transfer">Transfer</option>
                    <option value="Cheque">Cheque</option>
                    <option value="Giro">Giro</option>
                </x-combobox>
                @error('MPenjualan.jenis_pembayaran')
                <x-error-form>{{ $message }}</x-error-form>
                @enderror
            </x-form-group>
        </div>
        <div class="lg:w-1/2">
            <x-form-group caption="Marketing">
                <x-combobox
                    wire:model="MPenjualan.marketing"
                >
                    <option value="">-- Isi Marketing --</option>
                    <option value="Sony Suherman">Sony Suherman</option>
                </x-combobox>
                @error('MPenjualan.marketing')
                <x-error-form>{{ $message }}</x-error-form>
                @enderror
            </x-form-group>
            <x-form-group caption="Jatuh Tempo">
                <x-datepicker
                    wire:model="MPenjualan.jatuh_tempo"
                />
                @error('MPenjualan.jatuh_tempo')
                <x-error-form>{{ $message }}</x-error-form>
                @enderror
            </x-form-group>
        </div>

    </div>

    <x-button
        class="mt-2"
        wire:click.prevent="$emit('openModal', 'penjualan.penjualan-detail-modal')">
        >
        Tambah Detail
    </x-button>


    <livewire:penjualan.penjualan-detail-table/>

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

