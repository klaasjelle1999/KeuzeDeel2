<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\ChoiceOfSection;
use App\Entity\Period;
use App\Entity\Tier;
use App\FormType\CategoryFormType;
use App\FormType\ChoiceOfSectionFormType;
use App\FormType\EditCategoryFormType;
use App\FormType\TierFormType;
use App\FormType\UpdateChoiceOfSectionFormType;
use App\Manager\CategoryManager;
use App\Manager\ChoiceOfSectionManager;
use App\Manager\TierManager;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Facebook\WebDriver\Exception\NoAlertOpenException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /** @var EntityManagerInterface $em */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAllNonDeletedCategories();
        $choiceOfSections = $this->getDoctrine()->getRepository(ChoiceOfSection::class)->findNonDeletedChoiceOfSections();

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'categories' => $categories,
            'choiceOfSections' => $choiceOfSections,
        ]);
    }

    /**
     * @Route(path="/admin/keuzedeel", name="admin_choice_of_section")
     * @param Request $request
     * @param ChoiceOfSectionManager $choiceOfSectionManager
     * @return RedirectResponse|Response
     */
    public function choiceOfSection(Request $request, ChoiceOfSectionManager $choiceOfSectionManager)
    {
        $choiceOfSections = $this->getDoctrine()->getRepository(ChoiceOfSection::class)->findAll();
        $form = $this->createForm(ChoiceOfSectionFormType::class);
        $periods = $this->getDoctrine()->getRepository(Period::class)->findAll();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $choiceOfSectionManager->createChoiceOfSection($data);

            return $this->redirectToRoute('admin_choice_of_section');
        }

        return $this->render('admin/choiceofsection.html.twig', [
            'form' => $form->createView(),
            'choiceOfSections' => $choiceOfSections,
            'periods' => $periods,
        ]);
    }

    /**
     * @Route(path="/admin/keuzedeel/update/{choiceOfSection}", name="update_choice_of_section")
     * @param ChoiceOfSection $choiceOfSection
     * @param Request $request
     * @param ChoiceOfSectionManager $choiceOfSectionManager
     * @return Response
     */
    public function updateChoiceOfSection(ChoiceOfSection $choiceOfSection, Request $request, ChoiceOfSectionManager $choiceOfSectionManager)
    {
        if (!$choiceOfSection instanceof ChoiceOfSection) {
            throw new NotFoundHttpException('Dit keuzedeel is niet gevonden!');
        }

        if (isset($_POST['submitperiod'])) {
            $choiceOfSectionManager->addPeriodToChoiceOfSection($choiceOfSection, $_POST);
        }

        $periods = $this->getDoctrine()->getRepository(Period::class)->findAll();

        $form = $this->createForm(UpdateChoiceOfSectionFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $choiceOfSectionManager->updateChoiceOfSection($data, $choiceOfSection, $choiceOfSection->getExtraInformation());

            return $this->redirectToRoute('update_choice_of_section', [
                'choiceOfSection' => $choiceOfSection->getId(),
            ]);
        }

        return $this->render('admin/updatechoiceofsection.html.twig', [
            'choiceOfSection' => $choiceOfSection,
            'form' => $form->createView(),
            'periods' => $periods,
        ]);
    }

    /**
     * @Route(path="/admin/keuzedeel/hard-delete/{choiceOfSection}", name="hard-delete_choice_of_section")
     * @param ChoiceOfSection $choiceOfSection
     * @param ChoiceOfSectionManager $choiceOfSectionManager
     */
    public function hardDeleteChoiceOfSection(ChoiceOfSection $choiceOfSection, ChoiceOfSectionManager $choiceOfSectionManager)
    {
        if (!$choiceOfSection instanceof ChoiceOfSection) {
            throw new NotFoundHttpException('Dit keuzedeel is niet gevonden!');
        }

        $choiceOfSectionManager->hardDeleteChoiceOfSection($choiceOfSection);

        return $this->redirectToRoute('admin_choice_of_section');
    }

    /**
     * @Route(path="/admin/keuzedeel/delete/{choiceOfSection}", name="delete_choice_of_section")
     * @param ChoiceOfSection $choiceOfSection
     * @return RedirectResponse
     */
    public function deleteChoiceOfSection(ChoiceOfSection $choiceOfSection, ChoiceOfSectionManager $choiceOfSectionManager)
    {
        if (!$choiceOfSection instanceof ChoiceOfSection) {
            throw new NotFoundHttpException('Dit keuzedeel is niet gevonden!');
        }

        $choiceOfSectionManager->deleteChoiceOfSection($choiceOfSection);

        return $this->redirectToRoute('admin_choice_of_section');
    }

    /**
     * @Route(path="/admin/keuzedeel/activate/{choiceOfSection}", name="activate_choice_of_section")
     * @param ChoiceOfSection $choiceOfSection
     * @param ChoiceOfSectionManager $choiceOfSectionManager
     * @return RedirectResponse
     */
    public function activateChoiceOfSection(ChoiceOfSection $choiceOfSection, ChoiceOfSectionManager $choiceOfSectionManager)
    {
        if (!$choiceOfSection instanceof ChoiceOfSection) {
            throw new NotFoundHttpException('Dit keuzedeel is niet gevonden!');
        }

        $choiceOfSectionManager->activateChoiceOfSection($choiceOfSection);

        return $this->redirectToRoute('admin_choice_of_section');
    }

    /**
     * @Route(path="/admin/categorie", name="category")
     * @param Request $request
     * @return Response
     */
    public function category(Request $request, CategoryManager $categoryManager)
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAllNonDeletedCategories();
        $deletedCategories = $this->getDoctrine()->getRepository(Category::class)->findDeletedCategories();

        $form = $this->createForm(CategoryFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $categoryManager->createCategory($data->name);

            return $this->redirectToRoute('category');
        }

        return $this->render('admin/category.html.twig', [
            'form' => $form->createView(),
            'categories' => $categories,
            'deletedCategories' => $deletedCategories,
        ]);
    }

    /**
     * @Route(path="/admin/categorie/update/{category}", name="edit_category")
     * @param Request $request
     * @param Category $category
     * @param CategoryManager $categoryManager
     * @return Response
     */
    public function editCategory(Request $request, Category $category, CategoryManager $categoryManager)
    {
        $form = $this->createForm(EditCategoryFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $categoryManager->editCategory($category, $data);

            return $this->redirectToRoute('category');
        }

        return $this->render('admin/editcategory.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(path="/admin/niveau", name="tier")
     * @param Request $request
     * @param TierManager $tierManager
     * @return RedirectResponse|Response
     */
    public function tier(Request $request, TierManager $tierManager)
    {
        $tiers = $this->getDoctrine()->getRepository(Tier::class)->findAll();
        $form = $this->createForm(TierFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $tierManager->createTier($data);

            return $this->redirectToRoute('tier');
        }

        return $this->render('admin/tier.html.twig', [
            'form' => $form->createView(),
            'tiers' => $tiers,
        ]);
    }

    /**
     * @Route(path="/admin/niveau/delete/{tier}")
     * @param Tier|null $tier
     * @param TierManager $tierManager
     * @return RedirectResponse
     */
    public function deleteTier(Tier $tier = null, TierManager $tierManager)
    {
        if (!$tier instanceof Tier) {
            throw new NotAcceptableHttpException('Dit niveau is niet gevonden!');
        }

        $tierManager->deleteTier($tier);

        return $this->redirectToRoute('tier');
    }

    /**
     * @Route(path="/admin/category/delete/{category}", name="delete_category")
     * @param CategoryManager $categoryManager
     * @param Category|null $category
     * @return RedirectResponse
     */
    public function deleteCategory(CategoryManager $categoryManager, Category $category = null)
    {
        if  (!$category instanceof Category) {
            throw new NotFoundHttpException('Deze categorie is niet gevonden');
        }

        $categoryManager->deleteCategory($category);

        return $this->redirectToRoute('category');
    }

    /**
     * @Route(path="/admin/category/hard-delete/{category}", name="hard-delete_category")
     * @param Category $category
     * @param CategoryManager $categoryManager
     * @return RedirectResponse
     */
    public function hardDeleteCategory(Category $category, CategoryManager $categoryManager)
    {
        if (!$category instanceof Category) {
            throw new NotFoundHttpException('Deze categorie is niet gevonden!');
        }

        $categoryManager->hardDeleteCategory($category);

        return $this->redirectToRoute('category');
    }
    
    /**
     * @Route(path="/admin/category/activate/{category}", name="activate_category")
     * @param CategoryManager $categoryManager
     * @param Category|null $category
     * @return RedirectResponse
     */
    public function activateCategory(CategoryManager $categoryManager, Category $category = null)
    {
        if (!$category instanceof Category) {
            throw new NotFoundHttpException('Deze categorie is niet gevonden');
        }

        $categoryManager->activateCategory($category);

        return $this->redirectToRoute('category');
    }
}
