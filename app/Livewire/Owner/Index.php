<?php

namespace App\Livewire\Owner;
use App\Models\monthly_payment as MonthlyPayment;
use App\Models\Dormitory;
use App\Models\Tenant;

use App\Models\Reserve_Slot;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public $dormCount;
    public $tenantCount;
    public $reservationCount;
    public $monthlyIncome;

    public function mount()
    {
        // Get the number of dormitories, tenants, and reservations for the owner
        $this->dormCount = Dormitory::where('owner_id', Auth::id())->count();
        $this->tenantCount = Tenant::where('owner_id', Auth::id())->count();
        $this->reservationCount = Reserve_Slot::whereHas('dorm', function ($query) {
            $query->where('owner_id', Auth::id());
        })->count();

        $this->monthlyIncome = MonthlyPayment::where('status', 'paid')
        ->whereHas('tenant', function ($query) {
            $query->where('owner_id', Auth::id());
        })
        ->join('tenants', 'monthly_payments.tenant_id', '=', 'tenants.id')  // Join the tenants table
        ->sum('tenants.monthly_fee');

    }



    public function render()
    {
        return view('livewire.owner.index', [
            'dormCount' => $this->dormCount,
            'tenantCount' => $this->tenantCount,
            'reservationCount' => $this->reservationCount,
            'monthlyIncome' => $this->monthlyIncome,
        ]);
    }
}
