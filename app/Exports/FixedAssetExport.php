<?php

namespace App\Exports;

use App\Services\Inventory\FixedAssetService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class FixedAssetExport implements FromView
{
    public $state;
    public $unit;

    public function __construct($state, $unit)
    {
        $this->state = $state;
        $this->unit = $unit;
    }

    public function view(): View
    {
        if ($this->state != "" || $this->unit != 0) {
            return view('exports.fixed-asset', [
                'fixedAssets' => FixedAssetService::getAllByUnitAndState($this->state, $this->unit),
                'state' => $this->state,
                'unit' => $this->unit
            ]);
        } else {
            return view('exports.fixed-asset', [
                'fixedAssets' => FixedAssetService::getAll(),
            ]);
        }
    }
}
