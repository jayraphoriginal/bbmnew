<div>
    <x-header-modal>
        Input Ticket
    </x-header-modal>

    <x-form-group caption="Mutu Beton">
        <x-textbox
            readonly
            wire:model="mutubeton"
        />
    </x-form-group>

    <div class="xl:flex lg:flex  xl:gap-4 lg:gap-4">
        <div class="lg:w-1/2">
            
            <x-form-group caption="Kendaraan">
                <livewire:kendaraan.kendaraan-select :deskripsi="$kendaraan"/>
                @error('kendaraan_id')
                <x-error-form>{{ $message }}</x-error-form>
                @enderror
            </x-form-group>

            <x-form-group caption="Operator">
                <livewire:driver.driver-select :deskripsi="$driver"/>
                @error('driver_id')
                <x-error-form>{{ $message }}</x-error-form>
                @enderror
            </x-form-group>

            <x-form-group caption="Sisa SO">
                <x-textbox
                    readonly
                    wire:model="sisa_so"
                />
            </x-form-group>

            <x-form-group caption="Jumlah">
                <x-number-text
                    wire:model="jumlah"
                />
                @error('jumlah')
                <x-error-form>{{ $message }}</x-error-form>
                @enderror
                @error('stok')
                <x-error-form>{{ $message }}</x-error-form>
                @enderror
            </x-form-group>

            <x-form-group caption="Satuan">
                <x-textbox
                    readonly
                    wire:model="satuan"
                />
            </x-form-group>
            
        </div>
        <div class="lg:w-1/2">
            <x-form-group caption="Rate">
                <livewire:rate.rate-select :deskripsi="$rate"/>
                @error('rate_id')
                    <x-error-form>{{ $message }}</x-error-form>
                @enderror
            </x-form-group>

            <x-form-group caption="Jam Ticket">
                <x-datetime-picker
                    wire:model="jam_ticket"
                />
                @error('jam_ticket')
                    <x-error-form>{{ $message }}</x-error-form>
                @enderror
            </x-form-group>

            <x-form-group caption="Loading">
                <x-textbox
                    readonly
                    wire:model="loading"
                />
                @error('loading')
                <x-error-form>{{ $message }}</x-error-form>
                @enderror
            </x-form-group>

            <x-form-group caption="Tambahan Biaya">
                <x-number-text
                    wire:model="tambahan_biaya"
                />
                @error('tambahan_biaya')
                <x-error-form>{{ $message }}</x-error-form>
                @enderror
            </x-form-group>

            <x-form-group caption="Lembur">
                <x-number-text
                    wire:model="lembur"
                />
                @error('lembur')
                <x-error-form>{{ $message }}</x-error-form>
                @enderror
            </x-form-group>           
        </div>

    </div>

    <x-footer-modal>
        <button
            wire:loading.attr="disabled"
            class="px-4 py-2 my-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
            wire:click='save'>
            Save
        </button>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >cancel</x-secondary-button>
    </x-footer-modal>
</div>
