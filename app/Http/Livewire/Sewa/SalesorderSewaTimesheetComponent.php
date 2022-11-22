<?php

namespace App\Http\Livewire\Sewa;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SalesorderSewaTimesheetComponent extends Component
{
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Timesheet')){
            return abort(401);
        }
        return view('livewire.sewa.salesorder-sewa-timesheet-component');
    }
}
