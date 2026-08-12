<?php

namespace App\Livewire\Inquilinos;
use Livewire\Component;
use App\Models\Trent;
use Livewire\WithPagination;

class Index extends Component
{
    protected $paginationTheme = 'tailwind';
    public function paginationView()
    {
        return 'vendor.livewire.tailwind';
    }
    public function render()
    {
        return view('livewire.inquilinos.index', [
            'trents' => Trent::paginate(10),
        ]);
        //return view('livewire.inquilinos.index');
    }
}
