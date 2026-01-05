<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Production;
use Barryvdh\DomPDF\Facade\Pdf;
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

    public function downloadPdf($productionCode)
    {
        $this->selectedProduction = Production::with('customer', 'materials', 'stages')
            ->where('production_code', $productionCode)
            ->first();

        $pdf = Pdf::loadView('pdf.detail-production', ["production" => $this->selectedProduction])
            ->setPaper('a4');

        return response()->streamDownload(
            function () use ($pdf) {
                echo $pdf->output();
            },
            "produksi-{$productionCode}.pdf"
        );
    }
}
