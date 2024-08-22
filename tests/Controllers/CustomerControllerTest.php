<?php

namespace Tests\Controllers;

use Mockery;
use Tests\TestCase;
use App\Repositories\CustomerRepository;
use Laravel\Lumen\Testing\DatabaseTransactions;

/**
 * Class CustomerControllerTest
 */
class CustomerControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    
    /**
     * Test getAllCustomer method when the response is successful
     * @return void
     */
    public function test_getAllCustomer_when_the_request_is_correct_then_return_successful_response()
    {
        $mockedData = [
            [
                'first_name' => 'John',
                'last_name'  => 'Doe',
                'email'      => 'johndoe@gmail.com',
                'country'    => 'Australia'
            ],
            [
                'first_name' => 'Lorem',
                'last_name'  => 'Ipsum',
                'email'      => 'lipsum@gmail.com',
                'country'    => 'Australia'
            ]
        ];
        // Mock the repository
        $mockRepository = Mockery::mock(CustomerRepository::class)->shouldIgnoreMissing();
        $mockRepository->shouldReceive('getAllCustomer')->once()->andReturn($mockedData);

        $this->app->instance(CustomerRepository::class, $mockRepository);
    
        // Make a GET request to the API endpoint
        $response = $this->get('/api/customers');
        
        // Assert the response
        $response->assertResponseStatus(200);
        $response->seeJson([
            'data' => [
                [
                    'full_name' => 'John Doe',
                    'email'     => 'johndoe@gmail.com',
                    'country'   => 'Australia',
                ],
                [
                    'full_name' => 'Lorem Ipsum',
                    'email'     => 'lipsum@gmail.com',
                    'country'   => 'Australia',
                ]
            ],
        ]);
    }

    /**
     * Test getAllCustomer method when the response is empty
     * @return void
     */
    public function test_getAllCustomer_when_the_request_is_correct_then_return_empty_response()
    {
        $mockedData = [];
        // Mock the repository
        $mockRepository = Mockery::mock(CustomerRepository::class)->shouldIgnoreMissing();
        $mockRepository->shouldReceive('getAllCustomer')->once()->andReturn($mockedData);

        $this->app->instance(CustomerRepository::class, $mockRepository);
    
        // Make a GET request to the API endpoint
        $response = $this->get('/api/customers');
        
        // Assert the response
        $response->assertResponseStatus(200);
        $response->seeJson([
            'data' => []
        ]);
    }

    /**
     * Test getCustomerDetail method when the response is successful
     * @return void
     */
    public function test_getCustomerDetail_when_the_request_is_correct_then_return_successful_response()
    {
        $mockedData = [
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'email'      => 'johndoe@gmail.com',
            'username'   => 'johndoe',
            'gender'     => 'male',
            'country'    => 'Australia',
            'city'       => 'Maitland',
            'phone'      => '01-0884-6350'
        ];
        // Mock the repository
        $mockRepository = Mockery::mock(CustomerRepository::class)->shouldIgnoreMissing();
        $mockRepository->shouldReceive('getCustomerById')->once()->andReturn($mockedData);

        $this->app->instance(CustomerRepository::class, $mockRepository);
    
        // Make a GET request to the API endpoint
        $response = $this->get('/api/customers/7');

        // Assert the response
        $response->assertResponseStatus(200);
        $response->seeJson([
            'data' => [
                'full_name' => 'John Doe',
                'email'     => 'johndoe@gmail.com',
                'username'  => 'johndoe',
                'gender'    => 'male',
                'country'   => 'Australia',
                'city'      => 'Maitland',
                'phone'     => '01-0884-6350'
            ],
        ]);
    }

    /**
     * Test getCustomerDetail method when the response empty
     * @return void
     */
    public function test_getCustomerDetail_when_the_request_is_correct_then_return_empty()
    {
        $mockedData = [];
        // Mock the repository
        $mockRepository = Mockery::mock(CustomerRepository::class)->shouldIgnoreMissing();
        $mockRepository->shouldReceive('getCustomerById')->once()->andReturn($mockedData);

        $this->app->instance(CustomerRepository::class, $mockRepository);
    
        // Make a GET request to the API endpoint
        $response = $this->get('/api/customers/7');

        // Assert the response
        $response->assertResponseStatus(200);
        $response->seeJson([
            'data' => [],
        ]);
    }

    /**
     * Test getCustomerDetail method when the response is successful
     * @return void
     */
    public function test_getCustomerDetail_when_the_parameter_is_invalid_then_return_error_response()
    {
        // Make a GET request to the API endpoint
        $response = $this->get('/api/customers/test');

        // Assert the response
        $response->assertResponseStatus(400);
        $response->seeJson([
            'success' => false,
            'message' => 'The customer id must be an integer.'
        ]);
    }
}