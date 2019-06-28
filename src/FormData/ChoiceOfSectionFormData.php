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

    /**
     * @var string
     */
    public $contact_hours;

    /**
     * @var string
     */
    public $internship_hours;

    /**
     * @var string
     */
    public $examination;

    /**
     * @var string
     */
    public $cost;
}