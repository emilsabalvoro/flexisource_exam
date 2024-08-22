<?php

namespace App\Libraries\Api;

use App\Constants\ApiConstants;
use Illuminate\Config\Repository as ConfigRepository;

/** 
 * Class CustomerApiUtils
 */
class CustomerApiUtils extends BaseApiUtils
{
    /**
     * @var ConfigRepository
     */
    private $config;

    /**
     * CustomerApiUtils constructor
     */
    public function __construct(ConfigRepository $config)
    {
        $this->config = $config;
        $this->setBaseUri($this->config->get('importer.base_uri'));
    }

    /**
     * fetch australian customers only
     *
     * @param integer $results
     * @return array
     */
    public function getAustralianCustomers(int $results): array
    {
        return $this->request(ApiConstants::GET, '/', [
            ApiConstants::RESULTS     => $results,
            ApiConstants::NATIONALITY => $this->config->get('importer.nationality'),
            ApiConstants::INCLUDING   => $this->config->get('importer.fields')
        ]);
    }
}