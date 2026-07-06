<div>
    <x-header-modal>
        Input Penerimaan
    </x-header-modal>

    <x-form-group caption="Customer">
        <livewire:customer.customer-select :deskripsi="$customer"/>
        @error('customer_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Tanggal bayar">
        <x-datepicker
            wire:model="tgl_bayar"
        />
        @error('tgl_bayar')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Tipe">
        <x-combobox
            wire:model="tipe_pembayaran"
        >
            <option value="">-- Isi Tipe Pembayaran --</option>
            <option value="cash">Cash</option>
            <option value="transfer">Transfer</option>
            <option value="cheque">Cheque</option>
            <option value="giro">Giro</option>
        </x-combobox>
        @error('tipe_pembayaran')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Tanggal Jatuh Tempo">
        <x-datepicker
            wire:model="jatuh_tempo"
        />
        @error('jatuh_tempo')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="No Cheque / Giro">
        <x-textbox
            wire:model="nowarkat"
        />
        @error('nowarkat')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

     <x-form-group caption="Bank Asal">
        <livewire:bank.bank-select :deskripsi="$bankasal"/>
        @error('bank_asal_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Rekening Tujuan">
        <livewire:bank.rekening-select :deskripsi="$rekening"/>
        @error('rekening_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Jumlah">
        {{ number_format($jumlah, 0, ',', '.') }}
    </x-form-group>

    <x-checkbox-group caption="Retail" class="my-2">
        <x-checkbox wire:model="retail"/>
    </x-checkbox-group>

    <x-form-group caption="Keterangan">
        <x-textbox
            wire:model="keterangan"
        />
        @error('keterangan')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="No Bukti Kas">
        <x-textbox
            wire:model="nobuktikas"
        />
        @error('nobuktikas')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <div class="w-full overflow-x-auto">
        <table class="whitespace-no-wrap my-5">
            <thead>
                <tr
                    class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-3">No Invoice</th>
                    <th class="px-4 py-3">No So</th>
                    <th class="px-4 py-3">Tgl Cetak</th>
                    <th class="px-4 py-3">Total</th>
                    <th class="px-4 py-3">Dpp</th>
                    <th class="px-4 py-3">Ppn</th>
                    <th class="px-4 py-3">Sisa Invoice</th>
                    <th class="px-4 py-3">Jumlah Bayar</th>
                    <th class="px-4 py-3">Biaya</th>
                    <th class="px-4 py-3">Jumlah Biaya</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                @foreach($invoices as $invoice)
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">
                        {{ $invoice->noinvoice }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $invoice->noso }}
                    </td>
                    <td class="px-4 py-3">
                        {{ date_create($invoice->tgl_cetak)->format('d-m-Y') }}
                    </td>
                    <td class="px-4 py-3">
                        {{ number_format($invoice->total, 0, ',', '.') }}
                    </td>
                    <td class="px-4 py-3">
                        {{ number_format($invoice->dpp, 0, ',', '.') }}
                    </td>
                    <td class="px-4 py-3">
                        {{ number_format($invoice->ppn, 0, ',', '.') }}
                    </td>
                    <td class="px-4 py-3">
                        {{ number_format($invoice->sisa_invoice, 0, ',', '.') }}
                    </td>
                    <td class="px-4 py-3 w-96">
                        <x-number-text
                            wire:key="jumlah_bayar.{{ $invoice->id }}"
                            wire:model="jumlah_bayar.{{ $invoice->id }}"
                            wire:change="updateJumlahBayar({{ $invoice->id }})"
                        />

                        @error('jumlah_bayar.'.$invoice->id)
                            <x-error-form>{{ $message }}</x-error-form>
                        @enderror
                    </td>
                    <td class="px-4 py-3 w-96">
                        <x-combobox
                            wire:key="biaya.{{ $invoice->id }}"
                            wire:model="biaya.{{ $invoice->id }}"
                            wire:change="updateJumlahBayar({{ $invoice->id }})"
                        >
                            <option value="">-- Pilih Biaya --</option>
                            <option value="Full">Bayar Full</option>
                            <option value="Admin">Biaya Admin</option>
                            <option value="Diskon">Diskon Penjualan</option>
                        </x-combobox>

                        @error('biaya.'.$invoice->id)
                            <x-error-form>{{ $message }}</x-error-form>
                        @enderror
                    </td>
                    <td class="px-4 py-3 w-96">
                        <x-number-text
                            wire:key="jumlah_biaya.{{ $invoice->id }}"
                            wire:model="jumlah_biaya.{{ $invoice->id }}"
                            wire:change="updateJumlahBayar({{ $invoice->id }})"
                        />
                        @error('jumlah_biaya.'.$invoice->id)
                            <x-error-form>{{ $message }}</x-error-form>
                        @enderror
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

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
