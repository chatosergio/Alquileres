<?php

namespace App\Livewire\Base;

use Livewire\Component;
use Livewire\WithPagination;

abstract class BaseComponent extends Component
{
    use WithPagination;

    public function paginationView()
    {
        return 'vendor.livewire.tailwind';
    }

    public function paginationSimpleView()
    {
        return 'vendor.livewire.simple-tailwind';
    }
}