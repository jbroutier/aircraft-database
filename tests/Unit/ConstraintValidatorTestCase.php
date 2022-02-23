<?php

declare(strict_types=1);

namespace Tests\Unit;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface;

abstract class ConstraintValidatorTestCase extends TestCase
{
    use MockeryPHPUnitIntegration;

    protected ConstraintValidatorInterface $validator;

    protected function expectValidationError(string $message): void
    {
        $builder = \Mockery::mock(ConstraintViolationBuilderInterface::class);
        $builder
            ->expects('setParameter')
            ->once();

        $builder
            ->expects('addViolation')
            ->once();

        $context = \Mockery::mock(ExecutionContextInterface::class);
        $context
            ->expects('buildViolation')
            ->once()
            ->with($message)
            ->andReturn($builder);

        $this->validator->initialize($context);
    }

    protected function expectNoValidationError(): void
    {
        $context = \Mockery::mock(ExecutionContextInterface::class);
        $context
            ->expects('buildViolation')
            ->never();

        $this->validator->initialize($context);
    }

    /**
     * @param class-string<T> $className
     * @return T
     * @template T of ConstraintValidatorInterface
     */
    protected function getValidator(string $className): ConstraintValidatorInterface
    {
        $this->validator = new $className();

        return $this->validator;
    }
}
