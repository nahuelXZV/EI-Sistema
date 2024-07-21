<?php

namespace App\Exports;

use App\Services\Inventory\InventoryService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class InventoryExport implements FromView
{
    public $filter;

    public function __construct($filter)
    {
        $this->filter = $filter;
    }

    public function view(): View
    {
        return view('exports.inventory', [
            'inventories' => InventoryService::getAllExport($this->filter),
        ]);
    }
}
