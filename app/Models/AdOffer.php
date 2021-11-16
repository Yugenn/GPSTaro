<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdOffer extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'area_id',
        'reamaining_amount',
        'description',
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

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
