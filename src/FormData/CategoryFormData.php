<?php


namespace App\FormData;

use Symfony\Component\Validator\Constraints as Assert;

class CategoryFormData
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $name;
}