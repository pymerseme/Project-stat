<?php
/**
 * Created by PhpStorm.
 * User: pymerseme
 * Date: 18.10.18
 * Time: 12:55
 */

namespace App;

class TestClass
{
    public $firstName;
    protected $lastName;
    private $age;

    protected $data = [];

    public function __construct(string $firstName, string $lastName, int $age = null)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->age = $age;
    }

    protected function getData(bool $resetCache = false): array
    {
        if ($this->data === null || $resetCache) {
            $this->createData();
        }
        return $this->data;
    }

    private function createData(): void
    {
        $this->data = [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'age' => $this->age,
        ];
    }
}
