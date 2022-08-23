<div>
    <x-header-modal>
        Input Sales Order
    </x-header-modal>

    <div class="xl:flex lg:flex  xl:gap-4 lg:gap-4">
        <div class="lg:w-1/2">
            <x-form-group caption="Tanggal SO">
                <x-datepicker
                    wire:model="MSalesorder.tgl_so"
                />
                @error('MSalesorder.tgl_so')
                <x-error-form>{{ $message }}</x-error-form>
                @enderror
            </x-form-group>
            <x-form-group caption="Customer">
                <livewire:customer.customer-select :deskripsi="$customer"/>
                @error('MSalesorder.customer_id')
                <x-error-form>{{ $message }}</x-error-form>
                @enderror
            </x-form-group>
            <x-form-group caption="Pembayaran">
                <x-combobox
                    wire:model="MSalesorder.pembayaran"
                >
                    <option value="">-- Isi Pembayaran --</option>
                    <option value="Dimuka">Dimuka</option>
                    <option value="Dimuka Full">Dimuka Full</option>
                    <option value="Diakhir">Diakhir</option>
                    <option value="Waktu Tagihan">Waktu Tagihan</option>
                </x-combobox>
                @error('MSalesorder.pembayaran')
                <x-error-form>{{ $message }}</x-error-form>
                @enderror
            </x-form-group>
            <x-form-group caption="Jenis Pembayaran">
                <x-combobox
                    wire:model="MSalesorder.jenis_pembayaran"
                >
                    <option value="">-- Isi Jenis Pembayaran --</option>
                    <option value="Tunai">Tunai</option>
                    <option value="Transfer">Transfer</option>
                    <option value="Cheque">Cheque</option>
                    <option value="Giro">Giro</option>
                </x-combobox>
                @error('MSalesorder.jenis_pembayaran')
                <x-error-form>{{ $message }}</x-error-form>
                @enderror
            </x-form-group>
        </div>
        <div class="lg:w-1/2">
            <x-form-group caption="Marketing">
                <x-combobox
                    wire:model="MSalesorder.marketing"
                >
                    <option value="">-- Isi Marketing --</option>
                    <option value="Sony Suherman">Sony Suherman</option>
                </x-combobox>
                @error('MSalesorder.marketing')
                <x-error-form>{{ $message }}</x-error-form>
                @enderror
            </x-form-group>
            <x-form-group caption="Jatuh Tempo">
                <x-datepicker
                    wire:model="MSalesorder.jatuh_tempo"
                />
                @error('MSalesorder.jatuh_tempo')
                <x-error-form>{{ $message }}</x-error-form>
                @enderror
            </x-form-group>
        </div>

    </div>

    <button
        class="px-4 py-2 my-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
        wire:click='save'>
        Tambah Detail
    </button>


    <livewire:sewa.salesorder-sewa-detail-table m_salesorder_id="{{$salesorder_id}}"/>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >Tutup</x-secondary-button>
    </x-footer-modal>
</div>
