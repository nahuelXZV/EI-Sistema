<?php

namespace App\Livewire\Inventory\Inventory;

use App\Services\Inventory\InventoryService;
use Livewire\Component;

class ShowInventory extends Component
{
    public $breadcrumbs = [['title' => "Inventario", "url" => "inventory.list"], ['title' => "Ver", "url" => "inventory.show"]];

    public $inventory;

    public function mount($inventory)
    {
        $this->inventory = InventoryService::getOne($inventory);
    }

    public function render()
    {
        return view('livewire.inventory.inventory.show-inventory');
    }
}
