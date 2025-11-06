<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Production;
use Livewire\Attributes\On;
use App\Models\ProductionStage;

class ProductionStageManager extends Component
{
    public $record;

    public function mount($record)
    {
        $this->record = $record;
    }

    public function startStage($id)
    {
        $stage = ProductionStage::findOrFail($id);
        $production = Production::find($stage->production_id);


        $stage->update([
            'status' => 'in_progress',
            'start_date' => Carbon::now('Asia/Jakarta'),
        ]);


        // dari draft ke in_progress jika belum in_progress
        if ($production->status !== 'in_progess') {
            $production->update(['status' => 'in_progress']);
        }


        $this->dispatch('stage-updated');
    }

    public function completeStage($id)
    {
        $stage = ProductionStage::findOrFail($id);
        $production = $stage->production;

        $stage->update([
            'status' => 'done',
            'end_date' => Carbon::now('Asia/Jakarta'),
        ]);

        // Tidak ada satupun stage produksi yang statusnya BUKAN completed.
        $allDone = $production->stages()->where('status', '!=', 'done')->doesntExist();

        if ($allDone) {
            $production->update(['status' => 'completed']);
        }

        $this->dispatch('stage-updated');
    }


    #[On('stage-updated')]
    public function stageUpdated()
    {
        $this->record->refresh();
    }


    public function render()
    {
        return view('livewire.production-stage-manager');
    }
}
