<?php
declare(strict_types=1);

namespace App\Entity;

use Illuminate\Contracts\Auth\Authenticatable;

class User implements Authenticatable
{
    private $id;
    private $apiToken;
    private $name;
    private $email;
    private $password;

    public function __construct(
        int $id,
        string $apiToken,
        string $name,
        string $email,
        string $password = ''
    ) {
        $this->id = $id;
        $this->apiToken = $apiToken;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function getAuthIdentifierName()
    {
        return 'user_id';
    }

    /**
     * @return int
     */
    public function getAuthIdentifier(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getRememberToken(): string
    {
        return '';
    }

    public function setRememberToken($value)
    {
    }

    public function getRememberTokenName()
    {
        return '';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getAuthPassword(): string
    {
        return $this->password;
    }


}