<?php


namespace App\FormData;


use App\Entity\Category;
use Symfony\Component\Validator\Constraints as Assert;

class ChoiceOfSectionFormData
{
    /**
     * @Assert\NotBlank()
     * @var string
     */
    public $name;

    /**
     * @Assert\NotBlank()
     * @var Category
     */
    public $category;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $partOfDay;

    /**
     * @var string
     */
    public $tier;
}