<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 05.11.2020
 * Time: 0:11
 */

namespace App\Services;


use App\Http\Requests\MessageRequest;
use DOMDocument;
use Illuminate\Support\Facades\Log;

class HTMLCertificateParser implements CertificateParser
{
    /**
     * @param MessageRequest $request
     * @return mixed
     */
    public function parse(MessageRequest $request)
    {
        try {
            $dom=new DOMDocument();
            $dom->loadHTML($request->input('body-html'),
                LIBXML_HTML_NOIMPLIED | # Make sure no extra BODY
                LIBXML_HTML_NODEFDTD |  # or DOCTYPE is created
                LIBXML_NOERROR |        # Suppress any errors
                LIBXML_NOWARNING        # or warnings about prefixes.
            );
            $table=$dom->getElementsByTagName('table')->item(0);
            $rows=$table->getElementsByTagName('tr');

            $columns=$this->getColumns($rows->item(0));
            $certificates=$this->getCertificates($columns, $rows);
        } catch (\Exception $exception){
            Log::error("NotifyExpiredCertificates error:\n".$exception->getMessage());
        }
        return collect($certificates);
    }

    /**
     * @param $header
     * @return array
     */
    private function getColumns($header){

        $tds = $header->getElementsByTagName('td');
        $count_columns = $tds->count();
        $columns = array();
        for ($index = 0;  $index < $count_columns; $index++ ) //go to each section 1 by 1
        {
            array_push($columns, trim($tds->item($index)->nodeValue));
        }
        return $columns;
    }

    /**
     * @param $columns
     * @param $trs
     * @return array
     */
    private function getCertificates($columns, $trs)
    {
        $count = $trs->count();
        $certificates = [];
        $count_columns = count($columns);
        for ($item = 1;  $item < $count; $item++ ) //go to each section 1 by 1
        {
            $tds = $trs->item($item)->getElementsByTagName('td');
            $row = array();
            for ($i = 0;  $i < $count_columns; $i++ ){
                $row[$columns[$i]] = trim($tds->item($i)->nodeValue);
            }
            array_push($certificates, $row);
        }
        return $certificates;
    }
}