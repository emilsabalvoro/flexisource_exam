<?php

namespace App\Traits;

use App\Constants\ApiConstants;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

/** 
 * Trait ApiRequestTrait
 */
trait ApiRequestTrait
{
    /**
     * variable for base uri
     * @var string
     */
    private $baseUri;

    /**
     * Sets api base uri
     *
     * @param string $baseUri
     * @return void
     */
    protected function setBaseUri(string $baseUri): void
    {
        $this->baseUri = $baseUri;
    }

    /**
     * Create an http request depending on the method.
     *
     * @param string $method
     * @param string $uri
     * @param array $request
     * @return Response
     */
    protected function httpRequest(string $method, string $uri, array $request = []): Response
    {
        $method = strtolower($method);
        return Http::{$method}($this->baseUri . $uri, $request);
    }

    /**
     * Format api response
     *
     * @param Response $response
     * @return array
     */
    protected function formatApiResponse(Response $response): array
    {
        $data = $response->json();
        return [
            ApiConstants::SUCCESS => $response->successful(),
            ApiConstants::CODE    => $response->getStatusCode(),
            ApiConstants::DATA    => $data[ApiConstants::RESULTS] ?? $data
        ];
    }

    /**
     * Log api request
     *
     * @param string $logMessage
     * @param string $method
     * @param string $uri
     * @param array $request
     * @param Response $response
     * @return void
     */
    protected function logApiRequest(string $logMessage, string $method, string $uri, array $request, Response $response): void
    {
        Log::info($logMessage, [
            ApiConstants::HEADERS     => $response->headers(),
            ApiConstants::METHOD      => $method,
            ApiConstants::REQUEST     => $request,
            ApiConstants::ENDPOINT    => $uri,
            ApiConstants::RESPONSE    => $response->json(),
            ApiConstants::STATUS_CODE => $response->status()
        ]);
    }
}