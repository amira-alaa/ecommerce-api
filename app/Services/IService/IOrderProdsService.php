<?php
namespace App\Services\IService;

use Illuminate\Http\Request;

interface IOrderProdsService{
    public function GetAllOrderProdsForVendor(Request $request);
}



?>
