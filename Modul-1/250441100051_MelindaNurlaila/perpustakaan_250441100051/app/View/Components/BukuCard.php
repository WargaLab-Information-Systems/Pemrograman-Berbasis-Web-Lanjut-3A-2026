<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BukuCard extends Component
{
    public $judul;
    public $penulis;
    public $tahun;

    public function __construct($judul, $penulis, $tahun)
    {
        $this->judul = $judul;
        $this->penulis = $penulis;
        $this->tahun = $tahun;
    }

    public function render(): View|Closure|string
    {
        return view('components.buku-card');
    }
}