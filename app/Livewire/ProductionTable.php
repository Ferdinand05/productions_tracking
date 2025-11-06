<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Production;
use Livewire\Component;

class ProductionTable extends Component
{
    public function render()
    {
        return view('livewire.production-table');
    }

    public $customer;
    public $productions;


    public $showModalStage = false;
    public $showModalMaterial = false;
    public $selectedProduction;
    public $stages = [];
    public $materials = [];

    public function modalStage($productionCode)
    {
        $this->showModalStage = true;
        $this->selectedProduction = Production::with('stages')
            ->where('production_code', $productionCode)
            ->first();

        $this->stages = $this->selectedProduction->stages;
    }

    public function modalMaterial($productionCode)
    {
        $this->showModalMaterial = true;
        $this->selectedProduction = Production::with('materials')
            ->where('production_code', $productionCode)
            ->first();
        $this->materials = $this->selectedProduction->materials;
    }
}
