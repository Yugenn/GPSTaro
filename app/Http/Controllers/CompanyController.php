<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\AdOffer;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $adOffers = AdOffer::latest();
        //     ->with('entries')
        //     ->MyAdOffer()
        //     ->paginate(5);

        return view('auth.company.dashboard', compact('adOffers'));
    }
}
