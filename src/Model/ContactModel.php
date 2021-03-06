<?php

declare(strict_types=1);

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class ContactModel
{
    #[Assert\NotBlank]
    #[Assert\Email]
    #[Assert\Length(max: 180)]
    public ?string $address = null;

    #[Assert\IsTrue]
    public ?bool $consenting = null;

    #[Assert\NotBlank]
    #[Assert\Length(max: 10000)]
    public ?string $message = null;

    #[Assert\NotBlank]
    #[Assert\Length(max: 200)]
    public ?string $name = null;

    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    public ?string $subject = null;
}
