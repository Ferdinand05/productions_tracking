<?php

namespace App\Livewire;

use App\Models\Production;
use Livewire\Component;

class CheckProduction extends Component
{
    public function render()
    {
        return view('livewire.check-production');
    }

    public $customer_code;
    public $production;

    public function checkProduction()
    {
        $this->production = Production::where('code', $this->customer_code)->first();
    }
}
