<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Response;

class VcardController
{
    /**
     * Download vCard file (.vcf) for a profile
     */
    public function download(string $handle): Response
    {
        $cleanHandle = strtolower(ltrim($handle, '@'));
        $profile = Profile::where('handle', $cleanHandle)->firstOrFail();

        $name = $profile->display_name;
        $title = $profile->job_title ?: $profile->tagline ?: 'Creator';
        $company = $profile->company ?: 'BioLink';
        $email = $profile->user->email ?? '';
        $phone = $profile->phone ?? '';
        $url = url('/@' . $profile->clean_handle);
        $note = $profile->bio ?? '';

        $vcard = "BEGIN:VCARD\r\n";
        $vcard .= "VERSION:3.0\r\n";
        $vcard .= "FN:{$name}\r\n";
        $vcard .= "N:;{$name};;;\r\n";
        if (!empty($title)) $vcard .= "TITLE:{$title}\r\n";
        if (!empty($company)) $vcard .= "ORG:{$company}\r\n";
        if (!empty($email)) $vcard .= "EMAIL;TYPE=INTERNET:{$email}\r\n";
        if (!empty($phone)) $vcard .= "TEL;TYPE=CELL:{$phone}\r\n";
        $vcard .= "URL:{$url}\r\n";
        if (!empty($note)) $vcard .= "NOTE:" . str_replace(["\r", "\n"], ' ', $note) . "\r\n";
        $vcard .= "END:VCARD\r\n";

        $filename = "{$cleanHandle}.vcf";

        return response($vcard, 200, [
            'Content-Type' => 'text/vcard; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}
