<?php

namespace App\Http\Livewire\Penerimaan;

use Livewire\Component;

class PenerimaanComponent extends Component
{
    public $tahun;
    public function render()
    {
        return view('livewire.penerimaan.penerimaan-component');
    }
}
