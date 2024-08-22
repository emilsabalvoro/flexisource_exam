<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\BaseController;
use App\Repositories\CustomerRepository;
use Illuminate\Support\Facades\Validator;
use App\Transformers\Customer\GetAllCustomersTransformer;
use App\Transformers\Customer\GetCustomerDetailTransformer;

/** 
 * Class CustomerController
 */
class CustomerController extends BaseController
{   
    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     * CustomerController constructor
     * @param CustomerRepository $customerRepository
     */
    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;        
    }

    /**
     * get all customer
     * @return JsonResponse
     */
    public function getAllCustomer(): JsonResponse
    {
        $customers = $this->customerRepository->getAllCustomer(); 
        $transformedData = (new GetAllCustomersTransformer())->transform($customers);

        return response()->json($transformedData);
    }

    /**
     * get customer detail
     * @param integer $customerId
     * @return JsonResponse
     */
    public function getCustomerDetail($customerId): JsonResponse
    {
        try {
            $rules = [
                'customerId' => 'integer',
            ];
    
            $validator = Validator::make(['customerId' => $customerId], $rules);
    
            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first(), 400);
            }

            $customer = $this->customerRepository->getCustomerById($customerId);
            $transformedData = (new GetCustomerDetailTransformer())->transform($customer);
            
            return response()->json($transformedData);
        } catch(Throwable $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }
}