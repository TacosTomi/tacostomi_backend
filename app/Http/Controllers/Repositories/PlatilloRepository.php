<?php
namespace App\Http\Controllers\Repositories;

use App\Models\Categoria;
use App\Models\Platillo;
use Illuminate\Database\Console\Migrations\FreshCommand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlatilloRepository{

    public function obtenerPlatillos() {
        return Platillo::all();
    }   


}