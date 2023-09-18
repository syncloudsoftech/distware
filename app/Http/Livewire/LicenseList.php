<?php

namespace App\Http\Livewire;

use App\Models\License;
use App\Models\Plan;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class LicenseList extends Component
{
    use WithDataTable {
        filter as applyFilter;
    }

    public string $plan = '';

    public string $status = '';

    public string $fromDate = '';

    public string $toDate = '';

    public function filter(): void
    {
        $this->applyFilter();
        if ($this->filtering) {
            $this->emit('filteringEnabled');
        }
    }

    public function render()
    {
        $query = License::query();
        if ($this->q) {
            $query = $query->where(function ($query) {
                /** @var Builder $query */
                $query->where('name', 'like', "%$this->q%")
                    ->orWhere('email', 'like', "%$this->q%")
                    ->orWhere('phone', 'like', "%$this->q%")
                    ->orWhere('code', 'like', "%$this->q%");
            });
        }

        if ($this->plan) {
            $query = $query->whereHas('plan', function ($query) {
                /** @var Builder $query */
                $query->whereKey($this->plan);
            });
        }

        if ($this->status) {
            $query = $query->where('status', $this->status);
        }

        if ($this->fromDate) {
            $query = $query->whereDate('created_at', '>=', $this->fromDate);
        }

        if ($this->toDate) {
            $query = $query->whereDate('created_at', '<=', $this->toDate);
        }

        foreach ($this->order as $column => $direction) {
            $query = $query->orderBy($column, $direction);
        }

        $licenses = $query->paginate($this->length);
        $plans = Plan::all();

        return view('livewire.license-list', compact('plans', 'licenses'));
    }
}
