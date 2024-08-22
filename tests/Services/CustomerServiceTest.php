<?php

namespace Tests\Services;

use Mockery;
use Exception;
use Tests\TestCase;
use App\Services\CustomerService;
use App\Libraries\Api\CustomerApiUtils;
use App\Repositories\CustomerRepository;
use App\Exceptions\CustomerRequestException;

/** 
 * Class CustomerServiceTest
 */
class CustomerServiceTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    /**
     * Test fetchCustomer method when the response is success
     * @return void
     */
    public function test_fetchCustomers_when_the_request_is_correct_then_return_successful_response()
    {
        //Mock dependencies
        $apiUtilsMock = Mockery::mock(CustomerApiUtils::class);
        $repositoryMock = Mockery::mock(CustomerRepository::class);

        $mockResult = [
            'success' => true,
            'code'    => 200,
            'data'    => [
                [
                    'gender'   => 'male',
                    'name'     => [
                        'first' => 'John',
                        'last'  => 'Doe',
                    ],
                    'location' => [
                        'city'    => 'Maitland',
                        'country' => 'Australia',
                    ],
                    'email'    => 'johndoe@gmail.com',
                    'login'    => [
                        'username' => 'johndoe',
                        'password' => 'password',
                    ],
                    'phone'    => '04-4925-7795',
                ],
                [
                    'gender'   => 'female',
                    'name'     => [
                        'first' => 'Lorem',
                        'last'  => 'Ipsum',
                    ],
                    'location' => [
                        'city'    => 'Dubbo',
                        'country' => 'Australia',
                    ],
                    'email'    => 'lipsum@gmail.com',
                    'login'    => [
                        'username' => 'lipsum',
                        'password' => 'password2',
                    ],
                    'phone'    => '04-4925-7796',
                ],
                [
                    'gender'   => 'female',
                    'name'     => [
                        'first' => 'Jane',
                        'last'  => 'Doe',
                    ],
                    'location' => [
                        'city'    => 'Auckland',
                        'country' => 'Australia',
                    ],
                    'email'    => 'janedoe@gmail.com',
                    'login'    => [
                        'username' => 'janedoe',
                        'password' => 'password3',
                    ],
                    'phone'    => '04-4925-7797',
                ]
            ],
        ];

        $apiUtilsMock->shouldReceive('getAustralianCustomers')->andReturn($mockResult);

        $customerService = app()->make(CustomerService::class, [
            'customerApiUtils'   => $apiUtilsMock,
            'customerRepository' => $repositoryMock
        ]);

        $response = $customerService->fetchCustomers(3);

        $this->assertEquals($response, $mockResult);
    }

    /**
     * Test fetchCustomer method when the api response is error
     * @return void
     */
    public function test_fetchCustomers_when_api_errors()
    {
        //Mock dependencies
        $apiUtilsMock = Mockery::mock(CustomerApiUtils::class);
        $repositoryMock = Mockery::mock(CustomerRepository::class);

        $apiUtilsMock->shouldReceive('getAustralianCustomers')->andReturn([
            'success' => false,
            'code'    => 500,
            'data'    => 'Server Error',
        ]);

        $customerService = app()->make(CustomerService::class, [
            'customerApiUtils'   => $apiUtilsMock,
            'customerRepository' => $repositoryMock
        ]);

        $this->expectException(CustomerRequestException::class);

        $customerService->fetchCustomers(3);
    }

    /**
     * Test importCustomer method when the response is success
     * @return void
     */
    public function test_importCustomer_when_the_request_is_correct_then_return_successful_response()
    {
        //Mock dependencies
        $apiUtilsMock = Mockery::mock(CustomerApiUtils::class);
        $repositoryMock = Mockery::mock(CustomerRepository::class);

        $customerData = [
            'data'    => [
                [
                    'gender'   => 'male',
                    'name'     => [
                        'first' => 'John',
                        'last'  => 'Doe',
                    ],
                    'location' => [
                        'city'    => 'Maitland',
                        'country' => 'Australia',
                    ],
                    'email'    => 'johndoe@gmail.com',
                    'login'    => [
                        'username' => 'johndoe',
                        'password' => 'password',
                    ],
                    'phone'    => '04-4925-7795',
                ],
                [
                    'gender'   => 'female',
                    'name'     => [
                        'first' => 'Lorem',
                        'last'  => 'Ipsum',
                    ],
                    'location' => [
                        'city'    => 'Dubbo',
                        'country' => 'Australia',
                    ],
                    'email'    => 'lipsum@gmail.com',
                    'login'    => [
                        'username' => 'lipsum',
                        'password' => 'password2',
                    ],
                    'phone'    => '04-4925-7796',
                ],
                [
                    'gender'   => 'female',
                    'name'     => [
                        'first' => 'Jane',
                        'last'  => 'Doe',
                    ],
                    'location' => [
                        'city'    => 'Auckland',
                        'country' => 'Australia',
                    ],
                    'email'    => 'janedoe@gmail.com',
                    'login'    => [
                        'username' => 'janedoe',
                        'password' => 'password3',
                    ],
                    'phone'    => '04-4925-7797',
                ]
            ]
        ];

        $repositoryMock->shouldReceive('createOrUpdateCustomer')->once();

        $customerService = app()->make(CustomerService::class, [
            'customerApiUtils'   => $apiUtilsMock,
            'customerRepository' => $repositoryMock
        ]);

        $customerService->importCustomers($customerData);

        $this->assertTrue(true);
    }

    /**
     * Test importCustomer method when the response is error
     * @return void
     */
    public function test_importCustomer_when_data_is_missing_then_return_error_response()
    {
        //Mock dependencies
        $apiUtilsMock = Mockery::mock(CustomerApiUtils::class);
        $repositoryMock = Mockery::mock(CustomerRepository::class);

        $customerData = [
            'data'    => [
                [
                    'gender'   => 'male',
                    'name'     => [
                        'first' => 'John',
                        'last'  => 'Doe',
                    ],
                    'location' => [
                        'city'    => 'Maitland',
                        'country' => 'Australia',
                    ],
                    'email'    => 'johndoe@gmail.com',
                    'login'    => [
                        'username' => 'johndoe',
                        'password' => 'password',
                    ],
                ],
                [
                    'gender'   => 'female',
                    'name'     => [
                        'first' => 'Lorem',
                        'last'  => 'Ipsum',
                    ],
                    'location' => [
                        'city'    => 'Dubbo',
                        'country' => 'Australia',
                    ],
                    'email'    => 'lipsum@gmail.com',
                    'login'    => [
                        'username' => 'lipsum',
                        'password' => 'password2',
                    ],
                ],
                [
                    'gender'   => 'female',
                    'name'     => [
                        'first' => 'Jane',
                        'last'  => 'Doe',
                    ],
                    'location' => [
                        'city'    => 'Auckland',
                        'country' => 'Australia',
                    ],
                    'email'    => 'janedoe@gmail.com',
                    'login'    => [
                        'username' => 'janedoe',
                        'password' => 'password3',
                    ],
                ]
            ]
        ];

        $customerService = app()->make(CustomerService::class, [
            'customerApiUtils'   => $apiUtilsMock,
            'customerRepository' => $repositoryMock
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Undefined index: phone');

        $customerService->importCustomers($customerData);
    }
}