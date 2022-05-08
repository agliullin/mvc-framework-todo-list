<?php

namespace App\Form;

/**
 * Task form
 */
class TaskForm extends AForm
{
    /**
     * Name
     *
     * @var string
     */
    protected string $name;

    /**
     * Email
     *
     * @var string
     */
    protected string $email;

    /**
     * Description
     *
     * @var string
     */
    protected string $description;

    /**
     * Status
     *
     * @var bool
     */
    protected bool $status;

    /**
     * Get form fields
     *
     * @return array
     */
    public function getFormFields(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'description' => $this->description,
            'status' => $this->status,
        ];
    }

    /**
     * Load form by data
     *
     * @param $data
     * @return $this
     */
    public function load($data): self
    {
        $this->name = $data['name'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->description = $data['description'] ?? '';
        $this->status = $data['status'] ?? 0;

        return $this;
    }

    /**
     * Validate
     *
     * @return bool
     */
    public function validate(): bool
    {
        if (!$this->name || strlen($this->name) < 0 ||  strlen($this->name) > 250) {
            $this->errors['name'] = 'Введите корректное имя';
        }
        if (!$this->email || strlen($this->email) < 0 || false === filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Введите корретный email';
        }
        if (!$this->description || strlen($this->description) < 0 ||  strlen($this->description) > 500) {
            $this->errors['description'] = 'Введите корректное описание';
        }

        return !$this->errors;
    }
}