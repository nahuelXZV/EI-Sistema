<?php

namespace App\Livewire\Inventory\FixedAsset;

use App\Services\Inventory\FixedAssetService;
use Livewire\Component;

class ShowFixedAsset extends Component
{
    public $breadcrumbs = [['title' => "Activos Fijos", "url" => "fixed_asset.list"], ['title' => "Ver", "url" => "fixed_asset.show"]];

    public $inventory;

    public function mount($fixed_asset)
    {
        $this->inventory = FixedAssetService::getOneAll($fixed_asset);
    }

    public function render()
    {
        return view('livewire.inventory.fixed-asset.show-fixed-asset');
    }
}
