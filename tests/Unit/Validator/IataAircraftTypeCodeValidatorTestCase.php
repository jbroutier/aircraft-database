<?php

declare(strict_types=1);

namespace Tests\Unit\Validator;

use App\Validator\IataAircraftTypeCode;
use App\Validator\IataAircraftTypeCodeValidator;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Tests\Unit\ConstraintValidatorTestCase;

final class IataAircraftTypeCodeValidatorTestCase extends ConstraintValidatorTestCase
{
    /**
     * @testdox Passes validation when a valid value is provided.
     */
    public function testPassOnValidValue(): void
    {
        $constraint = new IataAircraftTypeCode();
        $validator = $this->getValidator(IataAircraftTypeCodeValidator::class);

        $this->expectNoValidationError();
        $validator->validate('A4F', $constraint);
        $validator->validate('32N', $constraint);
        $validator->validate('318', $constraint);
    }

    /**
     * @testdox Passes validation when a null value is provided.
     */
    public function testPassOnNullValue(): void
    {
        $constraint = new IataAircraftTypeCode();
        $validator = $this->getValidator(IataAircraftTypeCodeValidator::class);

        $this->expectNoValidationError();
        $validator->validate(null, $constraint);
    }

    /**
     * @testdox Fails validation when an invalid value is provided.
     */
    public function testFailOnInvalidValue(): void
    {
        $constraint = new IataAircraftTypeCode();
        $validator = $this->getValidator(IataAircraftTypeCodeValidator::class);

        $this->expectValidationError($constraint->message);
        $validator->validate('A4FD', $constraint);

        $this->expectValidationError($constraint->message);
        $validator->validate('32', $constraint);

        $this->expectValidationError($constraint->message);
        $validator->validate('a4fd', $constraint);
    }

    /**
     * @testdox Fails validation when an empty value is provided.
     */
    public function testFailOnEmptyValue(): void
    {
        $constraint = new IataAircraftTypeCode();
        $validator = $this->getValidator(IataAircraftTypeCodeValidator::class);

        $this->expectValidationError($constraint->message);
        $validator->validate('', $constraint);
    }

    /**
     * @testdox Throws when an unexpected constraint is provided.
     */
    public function testThrowOnUnexpectedType(): void
    {
        $constraint = new NotNull();
        $validator = $this->getValidator(IataAircraftTypeCodeValidator::class);

        $this->expectException(UnexpectedTypeException::class);
        $validator->validate('A4F', $constraint);
    }

    /**
     * @testdox Throws when an unexpected data type is provided.
     */
    public function testThrowOnUnexpectedValue(): void
    {
        $constraint = new IataAircraftTypeCode();
        $validator = $this->getValidator(IataAircraftTypeCodeValidator::class);

        $this->expectException(UnexpectedValueException::class);
        $validator->validate(42, $constraint);
    }
}
