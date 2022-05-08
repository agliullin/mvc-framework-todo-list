<?php

namespace App\Form;

/**
 * Abstract class for form
 */
abstract class AForm
{
    /**
     * Errors
     *
     * @var array
     */
    protected array $errors = [];

    /**
     * Get errors
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Get form fields
     *
     * @return array
     */
    abstract public function getFormFields(): array;

    /**
     * Validate fields
     *
     * @return bool
     */
    abstract public function validate(): bool;
}