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
            <x-form-group caption="Jenis Biaya">
                <x-combobox
                    wire:model="kode_biaya"
                >
                    <option value="">-- Isi COA Biaya --</option>
                    @foreach ($coa as $item)
                        <option value="{{ $item->kode_akun }}">{{ $item->kode_akun.' - '.$item->nama_akun }}</option>
                    @endforeach
                </x-combobox>
                @error('kode_biaya')
                <x-error-form>{{ $message }}</x-error-form>
                @enderror
            </x-form-group>
            
            @if($this->kode_biaya =='601002')
            <x-form-group caption="Kendaraan">
                    <livewire:kendaraan.kendaraan-select :deskripsi="$kendaraan"/>
                    @error('Mpo.beban_id')
                    <x-error-form>{{ $message }}</x-error-form>
                    @enderror
            </x-form-group>
            @elseif($this->kode_biaya =='601001')
            <x-form-group caption="Alat">
                    <livewire:alat.alat-select :deskripsi="$alat"/>
                    @error('Mpo.beban_id')
                    <x-error-form>{{ $message }}</x-error-form>
                    @enderror
            </x-form-group>
            @endif
        </div>

    </div>

    <x-button
    class="mt-2"
    wire:click.prevent="$emit('openModal', 'pembelian.purchaseorder-detail-modal')"
    >Tambah Detail</x-button>


    <livewire:pembelian.purchaseorder-detail-table po_id={{$po_id}}/>

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
