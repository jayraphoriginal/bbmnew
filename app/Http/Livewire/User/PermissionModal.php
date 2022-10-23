<?php

namespace App\Http\Livewire\User;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;
use Spatie\Permission\Models\Permission;

class PermissionModal extends ModalComponent
{
    use LivewireAlert;
    public $name;

    protected function rules() {
        return [
            'name' => 'required|min:2',
        ];
    }

    public function save(){

        $this->validate();

        Permission::create(['name' => $this->name]);
        
        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('user.permission-table', 'pg:eventRefresh-default');
    }

    public function render()
    {
        return view('livewire.user.permission-modal');
    }
}
