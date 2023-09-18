<?php

namespace App\Http\Livewire;

use App\Models\Update;
use Livewire\Component;

class UpdateList extends Component
{
    use WithDataTable {
        filter as applyFilter;
    }

    public string $published = '';

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
        $query = Update::query();
        if ($this->q) {
            $query = $query->where('version', 'like', "%$this->q%");
        }

        if ($this->published !== '') {
            $query = $query->where('published', $this->published === '1');
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

        $updates = $query->paginate($this->length);

        return view('livewire.update-list', compact('updates'));
    }
}
