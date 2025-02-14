<?php

declare(strict_types=1);

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\View\Component;

class Table extends Component
{
    public $tableColumns;
    public int $currentPage = 1;
    public int $lastPage = 0;

    public string $tableLimit = '';
    public string $tableSort = '';
    public string $tableDir = '';
    public string $tableFilters = '';
    public string $tablePage = '';

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name,
        public string $url,
        public array $filters = [],
        public array $columns = [],
        public int $resultsPerPage = 10,
        public string $defaultSort = 'name',
        public string $defaultSortOrder = 'desc',
    ) {

        $this->tableFilters = $name.'.filters';

        $this->tableColumns = json_encode($columns);

        // Session keys
        $this->tableLimit = $name.'.limit';
        $this->tableSort = $name.'.sort';
        $this->tableDir = $name.'.dir';
        $this->tableFilters = $name.'.filters';
        $this->tablePage = $name.'.page';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table');
    }
}
