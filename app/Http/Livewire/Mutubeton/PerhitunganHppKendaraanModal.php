<?php

namespace App\Http\Livewire\Mutubeton;

use App\Models\PerhitunganHppKendaraan;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class PerhitunganHppKendaraanModal extends ModalComponent
{
    public $komponen_id;
    public $komponen;
    public $nilai;

    use LivewireAlert;

    protected $rules=[
        'nilai' => 'required',
    ];

    public function mount($komponen_id)
    {
        $this->komponen_id = $komponen_id;
    }

    public function render()
    {
        $perhitunganHppKendaraan = PerhitunganHppKendaraan::findorFail($this->komponen_id);
        $this->komponen = $perhitunganHppKendaraan->komponen;
        $this->nilai = $perhitunganHppKendaraan->nilai;
        return view('livewire.mutubeton.perhitungan-hpp-kendaraan-modal');
    }

    public function save()
    {
        $this->validate();

        try {
            $perhitunganHppKendaraan = PerhitunganHppKendaraan::findorFail($this->komponen_id);
            $perhitunganHppKendaraan->nilai = $this->nilai;
            $perhitunganHppKendaraan->save();
            
            $this->alert('success', 'Save Success', [
                'position' => 'center'
            ]);

            $this->emitTo('mutubeton.perhitungan-hpp-kendaraan-table', 'pg:eventRefresh-default');

            $this->closeModal();

        } catch (Throwable $e) {
            $this->alert('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
