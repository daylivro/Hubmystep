<?php
namespace App\Actions\Scan;

use App\Models\Partner;
use Illuminate\Support\Str;
use App\Models\AtOurPartner;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GenerateScanCode
{
    public function execute(AtOurPartner $atOurPartner): string
    {
        $slug = $atOurPartner->partner->slug;
        $filename = time() .'-'.$slug . '.svg';
        $hash = Str::random(60);
        $encoding = route('scan.generate', [
            'hash' => $hash,
            'partner' => $atOurPartner->partner->slug,
            'user' => $atOurPartner->user->username
        ]);

        QrCode::color(184, 104, 7)
            ->size(200)
            ->generate($encoding, storage_path('app/public/' . $filename));

        $atOurPartner->update(['win_scan_url' => $filename]);
        return $filename;
    }
}
