<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\City;
use Illuminate\Database\Eloquent\Collection;

class AddressController extends Controller
{
    public function getBarangayList(int $cityId): Collection
    {
        return Barangay::select('id', 'name')->where('city_id', '=', $cityId)->get();
    }

    public function getCityList(int $provinceId): Collection
    {
        return City::select('id', 'name')->where('province_id', '=', $provinceId)->get();
    }
}
