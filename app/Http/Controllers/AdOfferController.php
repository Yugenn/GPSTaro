<?php

namespace App\Http\Controllers;

use App\Models\AdOffer;
use App\Models\JobOfferView;
use App\Models\Area;
use App\Http\Requests\AdOfferRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = '';
        foreach (config('fortify.users') as $guard) {
            if (Auth::guard(Str::plural($guard))->check()) {
                $user = Auth::guard(Str::plural($guard))->user();
            }
        }

        if (empty($user)) {
            return view('welcome');
        } else {
            $params = $request->query();
            $adOffers = AdOffer::search($params)->openData()
                ->with(['company', 'area'])->latest()->paginate(5);

            $area = $request->area;
            $adOffers->appends(compact('area'));
            $areas = Area::all();

            return view('ad_offers.index', compact('adOffers', 'areas'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $areas = Area::all();
        return view('ad_offers.create', compact('areas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AdOfferRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdOfferRequest $request)
    {
        $adOffer = new AdOffer($request->all());
        $adOffer->company_id = $request->user()->id;

        try {
            // 登録
            $adOffer->save();
        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors('広告掲載登録処理でエラーが発生しました');
        }

        return redirect()
            ->route('ad_offers.show', $adOffer)
            ->with('notice', '広告掲載情報を登録しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AdOffer  $adOffer
     * @return \Illuminate\Http\Response
     */
    public function show(AdOffer $adOffer)
    {
        return view('ad_offers.show', compact('adOffer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AdOffer  $adOffer
     * @return \Illuminate\Http\Response
     */
    public function edit(AdOffer $adOffer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\AdOfferRequest  $request
     * @param  \App\Models\AdOffer  $adOffer
     * @return \Illuminate\Http\Response
     */
    public function update(AdOfferRequest $request, AdOffer $adOffer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdOffer  $adOffer
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdOffer $adOffer)
    {
        //
    }
}
