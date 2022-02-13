<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ListProducts extends Component
{
    public $product;

    public function render()
    {
        return view('livewire.list-products');
    }
}
