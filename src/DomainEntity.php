<?php

namespace Scheduler;

use ICanBoogie\Inflector;

use Scheduler\Validation\IEntityValidator;

class DomainEntity
{

    protected $validator;
    protected $params;
    protected $attributes = [];

    public function __construct(IEntityValidator $validator)
    {
        $this->validator = $validator;
        $this->inflector = Inflector::get();
    }

    public function fromArray($data)
    {
        $this->params = $data;
        $this->fromParams();
    }

    protected function validate()
    {
        if (empty($this->validator)) {
            throw new \InvalidArgumentException('validator is missing');
        }
        $this->validator->validate($this);
    }

    protected function fromParams()
    {
        foreach ($this->attributes as $attribute) {
            if (!in_array($attribute, ['id', 'createdAt', 'updatedAt'])) {
                $this->$attribute = $this->params[$attribute];
            }
        }
        $this->validate();
    }

    public function getParams($key)
    {
        return empty($this->params[$key]) ? null : $this->params[$key];
    }

    public function __get($property)
    {
        if (in_array($property, $this->attributes)) {
            return $this->$property;
        } else {
            throw new \InvalidArgumentException("unknown property $property");
        }
    }

    public function asArray()
    {
        $data = [];
        foreach ($this->attributes as $field) {
            $data[$this->inflector->underscore($field)] = $this->$field;
        }
        return $data;
    }
}