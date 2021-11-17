<?php

namespace App\Http\Controllers;

use App\Models\AdOffer;
use App\Models\AdOfferView;
use App\Consts\CompanyConst;
use App\Models\Area;
use App\Consts\UserConst;
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
            // dd($adOffer);
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
        if (Auth::guard(UserConst::GUARD)->check()) {
            AdOfferView::updateOrCreate([
                'ad_offer_id' => $adOffer->id,
                'user_id' => Auth::guard(UserConst::GUARD)->user()->id,
            ]);
        }
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
        $areas = Area::all();
        return view('ad_offers.edit', compact('adOffer', 'areas'));
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
        if (Auth::guard(CompanyConst::GUARD)->user()->cannot('update', $adOffer)) {
            return redirect()->route('ad_offers.show', $adOffer)
                ->withErrors('自分の求人情報以外は更新できません');
        }
        $adOffer->fill($request->all());

        try {
            $adOffer->save();
        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors('求人情報更新処理でエラーが発生しました');
        }

        return redirect()->route('ad_offers.show', $adOffer)
            ->with('notice', '求人情報を更新しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdOffer  $adOffer
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdOffer $adOffer)
    {
        
        if (Auth::guard(CompanyConst::GUARD)->user()->cannot('delete', $adOffer)) {
            return redirect()->route('ad_offers.show', $adOffer)
                ->withErrors('自分の求人情報以外は削除できません');
        }

        try {
            $adOffer->delete();
        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors('求人情報削除処理でエラーが発生しました');
        }

        return redirect()->route('ad_offers.index')
            ->with('notice', '求人情報を削除しました');
    }
}
