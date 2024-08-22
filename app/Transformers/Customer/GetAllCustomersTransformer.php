<?php

namespace App\Transformers\Customer;

use Spatie\Fractal\Fractal;
use App\Transformers\BaseTransformer;

class GetAllCustomersTransformer extends BaseTransformer
{
    /**
     * get all customer transform
     *
     * @param array $customer
     * @return Fractal
     */
    public function transform($customers): Fractal
    {
        return fractal()
            ->collection($customers)
            ->transformWith(function ($data) {
                if (empty($data)) {
                    return [];
                }
                return [
                    'full_name' => $data['first_name'] . ' ' . $data['last_name'],
                    'email'     => $data['email'],
                    'country'   => $data['country']
                ];
            });
    }
}