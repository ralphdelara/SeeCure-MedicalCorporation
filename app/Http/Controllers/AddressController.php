<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use Illuminate\Database\Eloquent\Collection;

class AddressController extends Controller
{
    public function barangay(int $cityId): Collection
    {
        return Barangay::select('id', 'name')->where('city_id', '=', $cityId)->get();
    }
}
