<?php

namespace App\Http\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use DB;
use Throwable;

class DeleteModal extends ModalComponent
{
    use LivewireAlert;

    public function render()
    {
        return view('livewire.delete-modal');
    }

    public ?int $data_id = null;

    public array $data_ids = [];

    public string $TableName;

    public string $confirmationTitle = '';

    public string $confirmationDescription = '';

    public static function modalMaxWidth(): string
    {
        return 'md';
    }

    public static function closeModalOnEscape(): bool
    {
        return false;
    }

    public static function closeModalOnClickAway(): bool
    {
        return false;
    }

    public function cancel()
    {
        $this->closeModal();
    }

    public function confirm()
    {
        
        if ($this->data_id) {
            try{
                DB::table($this->TableName)->where('id',$this->data_id)->delete();
            }
            catch(Throwable $e){
                $this->alert('error', $e->getMessage(), [
                    'position' => 'center'
                ]);
                return;
            }
        }

        if ($this->data_ids) {
            DB::table($this->TableName)->whereIn('id', $this->data_ids)->delete();
        }

        $this->alert('warning', 'Delete Success', [
            'position' => 'center'
        ]);

        $this->closeModalWithEvents([
            'pg:eventRefresh-default',
        ]);
    }
}
