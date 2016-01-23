<?php

namespace Scheduler\Validation;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidationHelper {
    /**
     * @var ValidatorInterface
     */
    protected $validator;

    public function __construct(ValidatorInterface $validator )
    {
        $this->validator = $validator;
    }

    public function validate($value, $attributeType) {
        $method = 'valid'.ucfirst($attributeType);
        return $this->$method($value);
    }

    public function validName($name) {
        return $this->validator->validate($name, new Assert\NotNull());
    }

    public function validEmail($email) {
        return $this->validator->validate($email, new Assert\Email());
    }

    public function validPhone($phone) {
        return $this->validator->validate($phone, new Assert\NotNull());
    }


}