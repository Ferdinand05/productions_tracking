<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    public function printProduction($customer_code)
    {

        $customer = Customer::with(['productions', 'productions.stages', 'productions.materials'])
            ->where('customer_code', $customer_code)
            ->first();

        $productions = $customer->productions->sortByDesc('created_at')->values();
        $pdf = Pdf::loadView('pdf.customer-production', ['customer' => $customer, 'productions' => $productions]);
        return $pdf->download('customer_production_' . $customer_code . '.pdf');
    }
}
