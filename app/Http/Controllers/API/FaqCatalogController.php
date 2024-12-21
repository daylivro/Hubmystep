<?php

namespace App\Http\Controllers\API;

use App\Models\FaqCatalog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FaqCatalogResource;

/**
 * @group FAQ Catalog
 */
class FaqCatalogController extends Controller
{
    /**
     * Get all FAQ catalogs
     */
    public function index()
    {
        return FaqCatalogResource::collection(FaqCatalog::latest()->get());
    }

    /**
     * Get a specific FAQ catalog details
     */
    public function show(FaqCatalog  $faqCatalog)
    {
        return new FaqCatalogResource($faqCatalog);
    }

}
