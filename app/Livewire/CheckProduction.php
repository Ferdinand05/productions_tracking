<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer;
use App\Models\Production;
use Livewire\Attributes\Validate;

class CheckProduction extends Component
{
    public function render()
    {
        return view('livewire.check-production');
    }

    #[Validate('exists:customers,customer_code', message: 'Customer tidak ditemukan')]
    #[Validate('required', message: 'Isi kode customer anda!')]
    public $customer_code;
    public $productions = [];
    public $customer = '';
    public $message = "";
    public function checkProduction()
    {

        $this->reset(['productions', 'message']);
        $this->validate();

        $customer = Customer::with(['productions', 'productions.stages', 'productions.materials'])
            ->where('customer_code', $this->customer_code)
            ->first();


        $this->customer = $customer;

        if ($customer->productions->isEmpty()) {
            $this->message = 'Customer ini belum memiliki data produksi.';
            return;
        }

        $this->productions = $customer->productions->sortByDesc('created_at')->values();
    }
}
