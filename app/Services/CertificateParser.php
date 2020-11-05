<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 05.11.2020
 * Time: 0:11
 */

namespace App\Services;

use App\Http\Requests\MessageRequest;

interface CertificateParser
{
    /**
     * @param MessageRequest $request
     * @return mixed
     */
    public function parse(MessageRequest $request);
}