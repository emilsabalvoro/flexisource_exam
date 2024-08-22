<?php

namespace App\Libraries\Api;

use App\Constants\ApiConstants;
use App\Traits\ApiRequestTrait;

/** 
 * Class BaseApiUtils
 */
class BaseApiUtils
{
    use ApiRequestTrait;

    /**
     * Perform API request
     * @param string  $method
     * @param string  $uri
     * @param mixed[] $request
     */
    protected function request(string $method, string $uri, array $request = []): array
    {
        $response = $this->httpRequest($method, $uri, $request);
        $this->logApiRequest(ApiConstants::THIRD_PARTY_API, $method, $uri, $request, $response);

        return $this->formatApiResponse($response);
    }
}