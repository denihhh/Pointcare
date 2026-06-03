<?php

namespace App\Livewire\Concerns;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait GuardsInvalidPagination
{
    protected function ensureValidPage(LengthAwarePaginator $paginator, callable $refetchPageOne): LengthAwarePaginator
    {
        if ($paginator->currentPage() > $paginator->lastPage()) {
            $this->resetPage();

            return $refetchPageOne();
        }

        return $paginator;
    }
}
