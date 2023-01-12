<?php

declare(strict_types=1);

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class NotIn extends Constraint
{
    public function __construct(
        public array  $list,
        public string $message = 'This value should not be any of : {{ compared_values }}.',
        mixed         $options = null,
        array         $groups = null,
        mixed         $payload = null,
    ) {
        parent::__construct($options, $groups, $payload);
    }
}
