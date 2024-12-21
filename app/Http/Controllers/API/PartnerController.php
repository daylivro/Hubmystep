<?php

namespace App\Http\Controllers\API;

use App\Models\Partner;
use Illuminate\Http\Request;
use App\Models\PartnerCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\PartnerResource;
use App\Http\Requests\Partner\WalkingRequest;
use App\Http\Resources\PartnerCategoryResource;
use App\Models\AtOurPartner;

/**
 * @group Partner
 * @unauthenticated
 * This is the Partner controller
 */
class PartnerController extends Controller
{
    /**
     * Get all partners
     */
    public function index()
    {
        return PartnerResource::collection(Partner::latest()->with('category', 'reward')->get());
    }

    /**
     * Get a specific partner details
     */
    public function show(Partner $partner)
    {
        return new PartnerResource($partner);
    }

    /**
     * Get all partner types
     */
    public function getTypes()
    {
        return PartnerCategoryResource::collection(PartnerCategory::latest()->get());
    }

    /**
     * Get a specific partner type
     */
    public function showType(PartnerCategory $partnerCategory)
    {
        return new PartnerCategoryResource($partnerCategory->load('partners'));
    }
}
