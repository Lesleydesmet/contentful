<?php

namespace Markup\Contentful;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

/**
 * A trait providing methods for abstracted use of the Guzzle library.
 */
trait GuzzleAbstractionTrait
{
    /**
     * @var ClientInterface
     */
    private $guzzle;

    /**
     * @param Request $request
     * @param array   $queryParams
     * @return PromiseInterface
     */
    private function sendRequestWithQueryParams(Request $request, array $queryParams = [])
    {
        return $this->guzzle->sendAsync($request, [RequestOptions::QUERY => $queryParams]);
    }

    /**
     * @param string $uri
     * @param string $method
     * @return Request
     */
    private function createRequest($uri, $method)
    {
        return new Request($method, $uri);
    }

    /**
     * @param Request $request
     * @return string
     */
    private function getUriForRequest(Request $request, array $queryParams = [])
    {
        $uri = strval($request->getUri());
        if (count($queryParams) > 0) {
            $uri .= '?'.http_build_query($queryParams);
        }

        return $uri;
    }

    /**
     * @param Request $request
     * @param string     $header
     * @param string     $value
     * @return Request
     */
    private function setHeaderOnRequest(Request $request, $header, $value)
    {
        return $request->withHeader($header, $value);
    }

    /**
     * @param ResponseInterface $response
     * @return array
     */
    private function responseAsArrayFromJson($response)
    {
        return json_decode(strval($response->getBody()), true);
    }
}
