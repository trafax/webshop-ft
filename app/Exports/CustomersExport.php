<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View as View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class CustomersExport implements FromView
{
    public function view(): View
    {
        $customers = User::where('role', 'customer')->orderBy('lastname', 'ASC')->get();

        return view('customer.exports.customers', [
            'customers' => $customers
        ]);
    }
}
