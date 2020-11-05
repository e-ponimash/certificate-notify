<?php

namespace App\Http\Controllers;

use App\Certificate;
use App\Http\Requests\MessageRequest;
use App\Services\CertificateParser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class MailCertificateController extends Controller
{

    /**
     * @param CertificateParser $certificateParser
     * @param MessageRequest $messageRequest
     */
    public function store(CertificateParser $certificateParser, MessageRequest $messageRequest){
        $certificates = $certificateParser->parse($messageRequest);
        $certificates->each(function ($certificate){
            try{
                Certificate::create([
                    'merchant_id' => $certificate[env('FIELD_MERCHANT_ID', 'Merchant ID')],
                    'name' => $certificate[env('FIELD_NAME', 'Наименование')],
                    'legal_name' => $certificate[env('FIELD_LEGAL_NAME', 'Юр.Л.')],
                    'expired_at' => Carbon::createFromFormat('d.m.Y', $certificate[env('FIELD_EXPIRED_AT', 'Срок действия до:')])
                ]);
            } catch (\Exception $exception){
                Log::error("MailCertificateController error:\n".$exception->getMessage());
            }
        });
    }

}
