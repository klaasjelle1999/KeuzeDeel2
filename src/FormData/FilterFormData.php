<?php


namespace App\FormData;


use App\Entity\Category;
use App\Entity\PartOfDay;
use App\Entity\Tier;

class FilterFormData
{
    /**
     * @var Category
     */
    public $category;

    /**
     * @var PartOfDay
     */
    public $partOfDay;

    /**
     * @var Tier
     */
    public $tier;
}