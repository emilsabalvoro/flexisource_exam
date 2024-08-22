<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CustomerService;
use Doctrine\ORM\Exception\ORMException;
use App\Exceptions\CustomerRequestException;
use Illuminate\Config\Repository as ConfigRepository;

/** 
 * Class ImportCustomersCommand
 */
class ImportCustomersCommand extends Command
{
    /**
     * Name and signature of console command
     *
     * @var string
     */
    protected $signature = 'import:customers';

    /**
     * Description of console command
     *
     * @var string
     */
    protected $description = 'Import customer data from 3rd party API';

    /**
     * @var CustomerService
     */
    private $customerService;

    /**
     * @var ConfigRepository
     */
    private $config;

    /**
     * construct function
     *
     * @param CustomerService $customerService
     */
    public function __construct(CustomerService $customerService, ConfigRepository $config)
    {
        parent::__construct();

        $this->customerService = $customerService;
        $this->config = $config;
    }

    /**
     * execute the console command
     *
     * @return void
     */
    public function handle()
    {
        $results = (int) $this->config->get('importer.minimum_users');

        try {
            $this->info('Fetching customer data from API ...');
            $customers = $this->customerService->fetchCustomers($results);

            $this->info('Importing customers\' data ...');
            $this->customerService->importCustomers($customers);
            
            $this->info('Done importing customers\' data');
        } catch (CustomerRequestException $exception) {
            $this->error($exception->getMessage());
        } catch (ORMException $ormException) {
            $this->error($ormException->getMessage());
        }
    }
}