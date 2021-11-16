<?php

namespace App\Policies;

use App\Models\AdOffer;
use App\Models\Company;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdOfferPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the company can view any models.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(Company $company)
    {
        //
    }

    /**
     * Determine whether the company can view the model.
     *
     * @param  \App\Models\Company  $company
     * @param  \App\Models\AdOffer  $adOffer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Company $company, AdOffer $adOffer)
    {
        //
    }

    /**
     * Determine whether the company can create models.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Company $company)
    {
        //
    }

    /**
     * Determine whether the company can update the model.
     *
     * @param  \App\Models\Company  $company
     * @param  \App\Models\AdOffer  $adOffer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Company $company, AdOffer $adOffer)
    {
        return $company->id === $adOffer->company_id;
    }

    /**
     * Determine whether the company can delete the model.
     *
     * @param  \App\Models\Company  $company
     * @param  \App\Models\AdOffer  $adOffer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Company $company, AdOffer $adOffer)
    {
        return $company->id === $adOffer->company_id;
    }

    /**
     * Determine whether the company can restore the model.
     *
     * @param  \App\Models\Company  $company
     * @param  \App\Models\AdOffer  $adOffer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Company $company, AdOffer $adOffer)
    {
        //
    }

    /**
     * Determine whether the company can permanently delete the model.
     *
     * @param  \App\Models\Company  $company
     * @param  \App\Models\AdOffer  $adOffer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Company $company, AdOffer $adOffer)
    {
        //
    }
}
