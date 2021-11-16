<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\AdOffer;
use App\Models\Area;
use Carbon\Carbon;

use Illuminate\Database\Seeder;

class AdOfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = Company::take(10)->get();
        foreach ($companies as $company) {
            // 期限切れ且つ募集終了(期限昨日)
            AdOffer::create([
                'company_id' => $company->id,
                'area_id' => Area::inRandomOrder()->first()->id,
                'title' => $company->name . 'の求人情報1のタイトル',
                'description' => $company->name . 'の求人情報1の本文',
                'remaining_amount' => Carbon::yesterday()->toDateString(),
                'status' => 0,
            ]);
            // 募集終了(期限翌月)
            AdOffer::create([
                'company_id' => $company->id,
                'area_id' => Area::inRandomOrder()->first()->id,
                'title' => $company->name . 'の求人情報2のタイトル',
                'description' => $company->name . 'の求人情報2の本文',
                'remaining_amount' => Carbon::now()->firstOfMonth()->addMonth(1)->toDateString(),
                'status' => 0,
            ]);
            // 募集中(期限翌月)
            AdOffer::create([
                'company_id' => $company->id,
                'area_id' => Area::inRandomOrder()->first()->id,
                'title' => $company->name . 'の求人情報3のタイトル',
                'description' => $company->name . 'の求人情報3の本文',
                'remaining_amount' => Carbon::now()->firstOfMonth()->addMonth(1)->toDateString(),
            ]);
            // 募集中(期限翌々月)
            AdOffer::create([
                'company_id' => $company->id,
                'area_id' => Area::inRandomOrder()->first()->id,
                'title' => $company->name . 'の求人情報4のタイトル',
                'description' => $company->name . 'の求人情報4の本文',
                'remaining_amount' => Carbon::now()->firstOfMonth()->addMonth(2)->toDateString(),
            ]);
        }
    }
}
