<?php

namespace App\Transformers;

abstract class BaseTransformer
{
    abstract public function transform($data);
}