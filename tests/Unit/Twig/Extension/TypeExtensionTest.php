<?php

declare(strict_types=1);

namespace Tests\Unit\Twig\Extension;

use App\Twig\Extension\TypeExtension;
use PHPUnit\Framework\TestCase;

final class TypeExtensionTest extends TestCase
{
    /**
     * @testdox Method boolean() returns a boolean.
     */
    public function testBoolean(): void
    {
        $extension = new TypeExtension();

        self::assertIsBool($extension->boolean('true'));
        self::assertIsBool($extension->boolean('false'));
    }

    /**
     * @testdox Method boolean() returns null when an invalid value is provided.
     */
    public function testBooleanWithInvalidValue(): void
    {
        $extension = new TypeExtension();

        self::assertNull($extension->boolean('invalid'));
    }

    /**
     * @testdox Method date() returns an instance of DateTime.
     */
    public function testDate(): void
    {
        $extension = new TypeExtension();

        self::assertInstanceOf(\DateTime::class, $extension->date('1990-07-05'));
    }

    /**
     * @testdox Method date() returns null when an invalid value is provided.
     */
    public function testDateWithInvalidValue(): void
    {
        $extension = new TypeExtension();

        self::assertNull($extension->date(''));
        self::assertNull($extension->date('invalid'));
        self::assertNull($extension->date('1478-47-58'));
    }

    /**
     * @testdox Method float() returns a float.
     */
    public function testFloat(): void
    {
        $extension = new TypeExtension();

        self::assertIsFloat($extension->float('7.38471'));
        self::assertIsFloat($extension->float('95'));
    }

    /**
     * @testdox Method float() returns null when an invalid value is provided.
     */
    public function testFloatWithInvalidValue(): void
    {
        $extension = new TypeExtension();

        self::assertNull($extension->float(''));
        self::assertNull($extension->float('invalid'));
    }

    /**
     * @testdox Method integer() returns an integer.
     */
    public function testInteger(): void
    {
        $extension = new TypeExtension();

        self::assertIsInt($extension->integer('4'));
    }

    /**
     * @testdox Method integer() returns null when an invalid value is provided.
     */
    public function testIntegerWithInvalidValue(): void
    {
        $extension = new TypeExtension();

        self::assertNull($extension->integer(''));
        self::assertNull($extension->integer('invalid'));
        self::assertNull($extension->integer('937.45'));
    }

    /**
     * @testdox Method string() returns a string.
     */
    public function testString(): void
    {
        $extension = new TypeExtension();

        self::assertIsString($extension->string('lorem ipsum'));
    }

    /**
     * @testdox Method string() returns null when an invalid value is provided.
     */
    public function testStringWithInvalidValue(): void
    {
        $extension = new TypeExtension();

        self::assertNull($extension->string(''));
        self::assertNull($extension->string(' '));
    }

    /**
     * @testdox Method url() returns a string.
     */
    public function testUrl(): void
    {
        $extension = new TypeExtension();

        self::assertIsString($extension->url('https://lorem-ipsum.fr'));
    }

    /**
     * @testdox Method url() returns null when an invalid value is provided.
     */
    public function testUrlWithInvalidValue(): void
    {
        $extension = new TypeExtension();

        self::assertNull($extension->url(''));
        self::assertNull($extension->url('lorem-ipsum.fr'));
    }
}
