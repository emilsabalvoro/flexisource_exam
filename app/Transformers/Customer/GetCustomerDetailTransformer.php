<?php

namespace App\Transformers\Customer;

use App\Transformers\BaseTransformer;
use Spatie\Fractal\Fractal;

class GetCustomerDetailTransformer extends BaseTransformer
{
    /**
     * get customer detail transform
     * @param array $custome
     * @return Fractal
     */
    public function transform($customer): Fractal
    {
        return fractal()
            ->item($customer)
            ->transformWith(function ($data) {
                if (empty($data)) {
                    return [];
                }
                return [
                    'full_name' => $data['first_name'] . ' ' . $data['last_name'],
                    'email'     => $data['email'],
                    'username'  => $data['username'],
                    'gender'    => $data['gender'],
                    'country'   => $data['country'],
                    'city'      => $data['city'],
                    'phone'     => $data['phone']
                ];
            });
    }
}