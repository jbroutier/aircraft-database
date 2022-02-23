<?php

declare(strict_types=1);

namespace Tests\Unit\Validator;

use App\Validator\IcaoAircraftTypeCode;
use App\Validator\IcaoAircraftTypeCodeValidator;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Tests\Unit\ConstraintValidatorTestCase;

/**
 * @covers \App\Validator\IcaoAircraftTypeCodeValidator
 */
final class IcaoAircraftTypeCodeValidatorTestCase extends ConstraintValidatorTestCase
{
    /**
     * @testdox Passes validation when a valid value is provided.
     */
    public function testPassOnValidValue(): void
    {
        $constraint = new IcaoAircraftTypeCode();
        $validator = $this->getValidator(IcaoAircraftTypeCodeValidator::class);

        $this->expectNoValidationError();
        $validator->validate('A20N', $constraint);
        $validator->validate('SUCO', $constraint);
    }

    /**
     * @testdox Passes validation when a null value is provided.
     */
    public function testPassOnNullValue(): void
    {
        $constraint = new IcaoAircraftTypeCode();
        $validator = $this->getValidator(IcaoAircraftTypeCodeValidator::class);

        $this->expectNoValidationError();
        $validator->validate(null, $constraint);
    }

    /**
     * @testdox Fails validation when an invalid value is provided.
     */
    public function testFailOnInvalidValue(): void
    {
        $constraint = new IcaoAircraftTypeCode();
        $validator = $this->getValidator(IcaoAircraftTypeCodeValidator::class);

        $this->expectValidationError($constraint->message);
        $validator->validate('A', $constraint);

        $this->expectValidationError($constraint->message);
        $validator->validate('A20N1', $constraint);

        $this->expectValidationError($constraint->message);
        $validator->validate('a20n', $constraint);
    }

    /**
     * @testdox Fails validation when an empty value is provided.
     */
    public function testFailOnEmptyValue(): void
    {
        $constraint = new IcaoAircraftTypeCode();
        $validator = $this->getValidator(IcaoAircraftTypeCodeValidator::class);

        $this->expectValidationError($constraint->message);
        $validator->validate('', $constraint);
    }

    /**
     * @testdox Throws when an unexpected constraint is provided.
     */
    public function testThrowOnUnexpectedType(): void
    {
        $constraint = new NotNull();
        $validator = $this->getValidator(IcaoAircraftTypeCodeValidator::class);

        $this->expectException(UnexpectedTypeException::class);
        $validator->validate('A20N', $constraint);
    }

    /**
     * @testdox Throws when an unexpected data type is provided.
     */
    public function testThrowOnUnexpectedValue(): void
    {
        $constraint = new IcaoAircraftTypeCode();
        $validator = $this->getValidator(IcaoAircraftTypeCodeValidator::class);

        $this->expectException(UnexpectedValueException::class);
        $validator->validate(42, $constraint);
    }
}
