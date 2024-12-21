<?php

namespace App\Observers;

use App\Models\Partner;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PartnerObserver
{
    /**
     * Handle the Partner "created" event.
     */
    public function created(Partner $partner): void
    {
        $filename = time() . '.svg';
        $slug = $partner->slug;
        $qrcode = QrCode::color(184, 104, 7)
            ->size(200)
            ->generate($slug, $path = storage_path('app/public/' . $filename));

        $partner->qr_code = $filename;
        $partner->save();
    }

    /**
     * Handle the Partner "updated" event.
     */
    public function updated(Partner $partner): void
    {
        //
    }

    /**
     * Handle the Partner "deleted" event.
     */
    public function deleted(Partner $partner): void
    {
        //
    }

    /**
     * Handle the Partner "restored" event.
     */
    public function restored(Partner $partner): void
    {
        //
    }

    /**
     * Handle the Partner "force deleted" event.
     */
    public function forceDeleted(Partner $partner): void
    {
        //
    }
}
