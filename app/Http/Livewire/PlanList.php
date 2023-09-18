<?php

namespace App\Http\Livewire;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class PlanList extends Component
{
    use WithDataTable {
        filter as applyFilter;
    }

    public function filter(): void
    {
        $this->applyFilter();
        if ($this->filtering) {
            $this->emit('filteringEnabled');
        }
    }

    public function render()
    {
        $query = Plan::query();
        if ($this->q) {
            $query = $query->where(function ($query) {
                /** @var Builder $query */
                $query->where('name', 'like', "%$this->q%");
            });
        }

        foreach ($this->order as $column => $direction) {
            $query = $query->orderBy($column, $direction);
        }

        $plans = $query->paginate($this->length);

        return view('livewire.plan-list', compact('plans'));
    }
}
