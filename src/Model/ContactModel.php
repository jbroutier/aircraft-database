<?php

declare(strict_types=1);

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class ContactModel
{
    #[Assert\NotBlank]
    #[Assert\Length(max: 180)]
    #[Assert\Email]
    protected ?string $address = null;

    #[Assert\IsTrue]
    protected ?bool $consent = null;

    #[Assert\NotBlank]
    #[Assert\Length(max: 10000)]
    protected ?string $message = null;

    #[Assert\NotBlank]
    #[Assert\Length(max: 200)]
    protected ?string $name = null;

    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    protected ?string $subject = null;

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): ContactModel
    {
        $this->address = $address;
        return $this;
    }

    public function getConsent(): ?bool
    {
        return $this->consent;
    }

    public function setConsent(?bool $consent): ContactModel
    {
        $this->consent = $consent;
        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): ContactModel
    {
        $this->message = $message;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): ContactModel
    {
        $this->name = $name;
        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): ContactModel
    {
        $this->subject = $subject;
        return $this;
    }
}
