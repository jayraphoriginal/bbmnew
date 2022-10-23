<?php

namespace App\Http\Livewire\Jurnal;

use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Throwable;

class JurnalManualComponent extends Component
{

    public function render()
    {
        return view('livewire.jurnal.jurnal-manual-component');
    }
}
