<div>
    <x-header-modal>
        Input Purchase Order
    </x-header-modal>

    <div class="xl:flex lg:flex  xl:gap-4 lg:gap-4">
        <div class="lg:w-1/2">
            <x-form-group caption="Nomor Faktur">
                <x-textbox
                    wire:model="Mpo.nofaktur"
                />
                @error('Mpo.nofaktur')
                <x-error-form>{{ $message }}</x-error-form>
                @enderror
            </x-form-group>
            <x-form-group caption="Tanggal Masuk">
                <x-datepicker
                    wire:model="Mpo.tgl_masuk"
                />
                @error('MSalesorder.tgl_masuk')
                <x-error-form>{{ $message }}</x-error-form>
                @enderror
            </x-form-group>
            <x-form-group caption="Jatuh Tempo">
                <x-datepicker
                    wire:model="Mpo.jatuh_tempo"
                />
                @error('Mpo.jatuh_tempo')
                <x-error-form>{{ $message }}</x-error-form>
                @enderror
            </x-form-group>
            <x-form-group caption="Supplier">
                <livewire:supplier.supplier-select :deskripsi="$supplier"/>
                @error('Mpo.supplier_id')
                <x-error-form>{{ $message }}</x-error-form>
                @enderror
            </x-form-group>
        </div>
        <div class="lg:w-1/2">
            
            <x-form-group caption="Tipe">
                <x-combobox
                    wire:model="Mpo.tipe"
                >
                    <option value="">-- Isi Tipe --</option>
                    <option value="PPN">PPN</option>
                    <option value="NON PPN">Non PPN</option>
                </x-combobox>
                @error('Mpo.tipe')
                <x-error-form>{{ $message }}</x-error-form>
                @enderror
            </x-form-group>

            <x-form-group caption="Pemakaian">
                <x-combobox
                    wire:model="Mpo.pembebanan"
                >
                    <option value="">-- Isi Pemakaian --</option>
                    <option value="Langsung">Langsung</option>
                    <option value="Stok">Stok</option>
                </x-combobox>
                @error('Mpo.pembebanan')
                <x-error-form>{{ $message }}</x-error-form>
                @enderror
            </x-form-group>
            <x-form-group caption="Jenis Pembebanan">
                <x-combobox
                    wire:model="Mpo.jenis_pembebanan"
                >
                    <option value="">-- Isi Jenis Biaya --</option>
                    <option value="Biaya Kendaraan">Biaya Kendaraan</option>
                    <option value="Biaya Alat">Biaya Alat</option>
                    <option value="Biaya Lain-lain">Biaya Lain-lain</option>
                </x-combobox>
            </x-form-group>
            
            @if($Mpo->jenis_pembebanan == 'Biaya Kendaraan')
                <x-form-group caption="Kendaraan">
                    <livewire:kendaraan.kendaraan-select :deskripsi="$kendaraan"/>
                    @error('MSalesorder.beban_id')
                    <x-error-form>{{ $message }}</x-error-form>
                    @enderror
                </x-form-group>
            @elseif($Mpo->jenis_pembebanan == 'Biaya Alat')
                <x-form-group caption="Kendaraan">
                    <livewire:alat.alat-select :deskripsi="$alat"/>
                    @error('MSalesorder.beban_id')
                    <x-error-form>{{ $message }}</x-error-form>
                    @enderror
                </x-form-group>
            @endif
            
        </div>

    </div>

    <button
        class="px-4 py-2 my-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
        wire:click='save'>
        Tambah Detail
    </button>


    <livewire:pembelian.purchaseorder-detail-table po_id={{$po_id}}/>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >Tutup</x-secondary-button>
    </x-footer-modal>
</div>
