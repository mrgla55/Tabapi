<?php

namespace Mrgla55\Tabapi\Formatters;

use Mrgla55\Tabapi\Interfaces\FormatterInterface;

class XMLFormatter implements FormatterInterface
{
    public function setHeaders()
    {
        $headers['Accept'] = 'application/xml';
        $headers['Content-Type'] = 'application/xml';

        return $headers;
    }

    public function setBody($data)
    {
        return urlencode($data);
    }

    public function formatResponse($response)
    {
        $body = $response->getBody();
        $contents = (string) $body;
        $decodedXML = simplexml_load_string($contents);

        return $decodedXML;
    }
}