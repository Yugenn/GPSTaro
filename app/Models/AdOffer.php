<?php

namespace App\Models;

use App\Consts\CompanyConst;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AdOffer extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'area_id',
        'remaining_amount',
        'description',
        'status',
    ];

    public function scopeOpenData(Builder $query)
    {
        $query->where('status', true)
            ->where('remaining_amount', '>=', now());

        return $query;
    }

    public function scopeSearch(Builder $query, $params)
    {
        if (!empty($params['area'])) {
            $query->where('area_id', $params['area']);
        }

        return $query;
    }

    public function scopeMyAdOffer(Builder $query)
    {
        $query->where(
            'company_id',
            Auth::guard(CompanyConst::GUARD)->user()->id
        );

        return $query;
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function adOfferViews()
    {
        return $this->hasMany(AdOfferView::class);
    }
}
