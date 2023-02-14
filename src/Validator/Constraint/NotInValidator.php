<?php

declare(strict_types=1);

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use function implode;

class NotInValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof NotIn) {
            throw new UnexpectedTypeException($constraint, NotIn::class);
        }

        if (null === $value) {
            return;
        }

        $found = in_array($value, $constraint->list, true);

        if (true === $found) {
            $violationBuilder = $this->context
                ->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $this->formatValue($value, self::OBJECT_TO_STRING | self::PRETTY_DATE))
                ->setParameter('{{ compared_values }}', implode(', ', $constraint->list));

            $violationBuilder->addViolation();
        }
    }
}
