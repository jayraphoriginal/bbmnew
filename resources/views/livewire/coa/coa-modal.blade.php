<div>
    <x-header-modal>
        Input Bahan Bakar
    </x-header-modal>

    <x-form-group caption="Kode Akun">
        <x-textbox
            wire:model="coa.kode_akun"
        />
        @error('coa.kode_akun')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Nama Akun">
        <x-textbox
            wire:model="coa.nama_akun"
        />
        @error('coa.nama_akun')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Level">
        <x-combobox
            wire:model="coa.level"
        >
            <option value="">-- Level --</option>
            @for($i=1;$i<=6;$i++)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </x-combobox>
        @error('coa.level')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>
  
    <x-form-group caption="Tipe">
        <x-combobox
            wire:model="coa.tipe"
        >
            <option value="">-- Tipe --</option>
            <option value="Header">Header</option>
            <option value="Detail">Detail</option>
        </x-combobox>
        @error('coa.tipe')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Posisi">
        <x-combobox
            wire:model="coa.posisi"
        >
            <option value="">-- Posisi --</option>
            <option value="Asset">Asset</option>
            <option value="Liability">Liability</option>
            <option value="Equity">Equity</option>
            <option value="Revenue">Revenue</option>
            <option value="Expense">Expense</option>

        </x-combobox>
        @error('coa.posisi')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Header Akun">
        <x-combobox
            wire:model="coa.header_akun"
        >
            <option value="">-- Header Akun --</option>
            @foreach ($header as $item)
            <option value="{{ $item->kode_akun }}">{{ $item->kode_akun.' - '.$item->nama_akun }}</option>
            @endforeach
        </x-combobox>
        @error('coa.header_akun')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >Cancel</x-secondary-button>
        <x-button
            wire:click="save">Save</x-button>
    </x-footer-modal>
</div>
