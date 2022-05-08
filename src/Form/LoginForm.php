<?php

namespace App\Form;

use App\Entity\User;
use Core\Application;
use Exception;

/**
 * Login form
 */
class LoginForm extends AForm
{
    /**
     * Username
     *
     * @var string
     */
    protected string $username;

    /**
     * Password
     *
     * @var string
     */
    protected string $password;

    /**
     * Get form fields
     *
     * @return array
     */
    public function getFormFields(): array
    {
        return [
            'username' => $this->username,
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
        $this->username = $data['username'] ?? '';
        $this->password = $data['password'] ?? '';

        return $this;
    }

    /**
     * Validate
     *
     * @return bool
     * @throws Exception
     */
    public function validate(): bool
    {
        $user = $this->getUser();

        if (!$user) {
            $this->errors['username'] = 'Нет пользователя с таким логином';
        }

        if ($user && !$user->verifyPasswordHash($this->password, $user->getPassword())) {
            $this->errors['password'] = 'Пароль введен неверно';
        }

        return !$this->errors;
    }

    /**
     * Get user by username
     *
     * @return mixed
     * @throws Exception
     */
    public function getUser()
    {
        $entityManager = Application::getInstance()->make('database');
        $userRepository = $entityManager->getRepository(User::class);

        return $userRepository->findOneBy(['username' => $this->username]);
    }
}