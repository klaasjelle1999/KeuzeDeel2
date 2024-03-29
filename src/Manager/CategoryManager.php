<?php


namespace App\Manager;


use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\Date;

class CategoryManager
{
    /** @var EntityManagerInterface $em */
    private $em;

    /**
     * CategoryManager constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function createCategory(string $name)
    {
        $category = new Category();
        $category->setName($name);

        $this->em->persist($category);
        $this->em->flush();
    }

    public function editCategory(Category $category, $data)
    {
        $category->setName($data->name);

        $this->em->merge($category);
        $this->em->flush();
    }

    public function deleteCategory(Category $category)
    {
        foreach ($category->getChoiceOfSections() as $choiceOfSection) {
            $choiceOfSection->setDeletedAt(new \DateTime('now'));
            $this->em->merge($choiceOfSection);
        }

        $category->setDeletedAt(new \DateTime('now'));

        $this->em->flush();
    }

    public function hardDeleteCategory(Category $category)
    {
        $choiceOfSections = $category->getChoiceOfSections();
        $notSelectedCategory = $this->em->getRepository(Category::class)->find(1);

        foreach ($choiceOfSections as $choiceOfSection) {
            $category->removeChoiceOfSection($choiceOfSection);
            $choiceOfSection->setCategory($notSelectedCategory);
            $this->em->merge($category);
        }

        $this->em->remove($category);
        $this->em->flush();
    }

    public function activateCategory(Category $category)
    {
        $category->setDeletedAt(null);

        $this->em->merge($category);
        $this->em->flush();
    }
}