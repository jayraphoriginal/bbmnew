<?php

namespace App\Http\Livewire\Jurnal;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Throwable;

class JurnalManualComponent extends Component
{

    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Jurnal Manual')){
            return abort(401);
        }
        return view('livewire.jurnal.jurnal-manual-component');
    }
}
