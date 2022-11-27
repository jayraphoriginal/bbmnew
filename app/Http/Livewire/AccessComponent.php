<?php

namespace App\Http\Livewire;

use App\Models\Permission as ModelsPermission;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Spatie\Permission\Contracts\Permission;

class AccessComponent extends Component
{
    use LivewireAlert;

    public $users, $permissions, $user_id;
    public $selectedpermission = [];

    public function mount(){
        $this->users = User::orderBy('name')->get();
        $this->permissions = ModelsPermission::orderBy('name')->get();
    }

    public function selectuser(){
        if ($this->user_id === ''){
            foreach($this->permissions as $permission){
                $this->selectedpermission[$permission->id] = false;
            }
        }
        else{
            $user = User::find($this->user_id);
            foreach($this->permissions as $permission){
                if ($user->hasPermissionTo($permission->id)){
                    $this->selectedpermission[$permission->id] = true;
                }else{
                    $this->selectedpermission[$permission->id] = false;
                }
            }
        }
    }

    public function save(){
        $user = User::find($this->user_id);
        foreach($this->selectedpermission as $permission_id => $selected){
            if ($selected == true){
                $permission = ModelsPermission::find($permission_id);
                $user->givePermissionTo($permission->name);
            }
        }
        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);
    }

    public function cancel(){
        $this->user_id = '';
        $this->selectuser();
    }

    public function render()
    {
        return view('livewire.access-component');
    }
}
