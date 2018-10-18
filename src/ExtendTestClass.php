<?php
/**
 * Created by PhpStorm.
 * User: pymerseme
 * Date: 18.10.18
 * Time: 12:55
 */

namespace App;

class ExtendTestClass extends TestClass
{
    public $country;
    public $city;
    protected $card;

    public function __construct(string $firstName, string $lastName, int $age = null)
    {
        parent::__construct($firstName, $lastName, $age);
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function setCard(string $card): void
    {
        $this->card = $card;
    }

    protected function getCard(): string
    {
        return $this->card;
    }
}
