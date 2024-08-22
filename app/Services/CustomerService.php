<?php

namespace App\Services;

use App\Constants\ApiConstants;
use App\Exceptions\CustomerRequestException;
use App\Libraries\Api\CustomerApiUtils;
use App\Repositories\CustomerRepository;

/** 
 * Class CustomerService
 */
class CustomerService
{
    /**
     * @var CustomerApiUtils
     */
    private $customerApiUtils;

    /**
     * @var CustomerRepositorys
     */
    private $customerRepository;

    /**
     * CustomerService constructor
     *
     * @param CustomerApiUtils $customerApiUtils
     */
    public function __construct(CustomerApiUtils $customerApiUtils, CustomerRepository $customerRepository)
    {
        $this->customerApiUtils = $customerApiUtils;
        $this->customerRepository = $customerRepository;
    }
    
    /**
     * fetch random customer data
     * @param integer $results
     * @return array
     */
    public function fetchCustomers(int $results): array
    {
        $response = $this->customerApiUtils->getAustralianCustomers($results);

        if ($response[ApiConstants::SUCCESS] === false) {
            throw new CustomerRequestException($response[ApiConstants::CODE], $response[ApiConstants::DATA]);
        }

        return $response;
    }

    /**
     * get the necessary customer data and import/update in database
     *
     * @param array $customers
     * @return void
     */
    public function importCustomers(array $customers): void
    {
        $customerData = $this->getNecessaryCustomerData($customers);
        $this->customerRepository->createOrUpdateCustomer($customerData);
    }

    /**
     * get the necessary customer data to be imported
     *
     * @param array $customers
     * @return array
     */
    private function getNecessaryCustomerData(array $customers): array
    {
        return array_map(function ($customer) {
            return [
                'first_name' => $customer['name']['first'],
                'last_name'  => $customer['name']['last'],
                'gender'     => $customer['gender'],
                'country'    => $customer['location']['country'],
                'city'       => $customer['location']['city'],
                'email'      => $customer['email'],
                'username'   => $customer['login']['username'],
                'password'   => $customer['login']['password'],
                'phone'      => $customer['phone']
            ];
        }, $customers[ApiConstants::DATA]);
    }
}