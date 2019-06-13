<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\ChoiceOfSection;
use App\FormType\FilterFormType;
use http\Env\Request;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Choice;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return Response
     */
    public function index(\Symfony\Component\HttpFoundation\Request $request)
    {
        $choiceOfSections = $this->getDoctrine()->getRepository(ChoiceOfSection::class)->findNonDeletedChoiceOfSections();
        $form = $this->createForm(FilterFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            if ($data->category->getId() !== 1 && $data->partOfDay->getId() !== 1 && $data->tier->getId() !== 1) {
                $choiceOfSections = $this
                    ->getDoctrine()
                    ->getRepository(ChoiceOfSection::class)
                    ->filterChoiceOfSections($data->category, $data->partOfDay, $data->tier)
                ;
            } elseif ($data->category->getId() !== 1 && $data->tier->getId() !== 1 && $data->partOfDay->getId() === 1) {
                $choiceOfSections = $this
                    ->getDoctrine()
                    ->getRepository(ChoiceOfSection::class)
                    ->filterChoiceOfSectionsV2($data->category, $data->tier)
                ;
            } elseif ($data->partOfDay->getId() !== 1 && $data->tier->getId() !== 1 && $data->category->getId() === 1) {
                $choiceOfSections = $this
                    ->getDoctrine()
                    ->getRepository(ChoiceOfSection::class)
                    ->filterChoiceOfSectionsV3($data->partOfDay, $data->tier)
                ;
            } elseif ($data->category->getId() !== 1 && $data->partOfDay->getId() !== 1 && $data->tier->getId() === 1) {
                $choiceOfSections = $this
                    ->getDoctrine()
                    ->getRepository(ChoiceOfSection::class)
                    ->filterChoiceOfSectionsV4($data->category, $data->partOfDay)
                ;
            } elseif ($data->tier->getId() !== 1 && $data->category->getId() === 1 && $data->partOfDay === 1) {
                $choiceOfSections = $this
                    ->getDoctrine()
                    ->getRepository(ChoiceOfSection::class)
                    ->filterChoiceOfSectionsV5($data->tier)
                ;
            } elseif ($data->partOfDay->getId() !== 1 && $data->tier->getId() === 1 && $data->category->getId() === 1) {
                $choiceOfSections = $this
                    ->getDoctrine()
                    ->getRepository(ChoiceOfSection::class)
                    ->filterChoiceOfSectionsV6($data->partOfDay)
                ;
            } elseif ($data->category->getId() !== 1 && $data->partOfDay->getId() === 1 && $data->tier->getId() === 1) {
                $choiceOfSections = $this
                    ->getDoctrine()
                    ->getRepository(ChoiceOfSection::class)
                    ->filterChoiceOfSectionsV7($data->category)
                ;
            }

            return $this->render('homepage/index.html.twig', [
                'controller_name' => 'HomepageController',
                'choiceOfSections' => $choiceOfSections,
                'form' => $form->createView(),
            ]);
        }
        return $this->render('homepage/index.html.twig', [
            'controller_name' => 'HomepageController',
            'choiceOfSections' => $choiceOfSections,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(path="/keuzedeel/{choiceOfSection}", name="choice_of_section")
     * @param ChoiceOfSection $choiceOfSection
     * @return Response
     */
    public function choiceOfSection(ChoiceOfSection $choiceOfSection)
    {
        if (!$choiceOfSection instanceof ChoiceOfSection) {
            throw new NotFoundHttpException('Dit keuzedeel is niet gevonden!');
        }

        return $this->render('homepage/choiceofsection.html.twig', [
            'choiceOfSection' => $choiceOfSection,
        ]);
    }

    /**
     * @Route(path="/show/{choiceOfSection}", name="show_choiceofsection")
     * @param ChoiceOfSection $choiceOfSection
     * @return Response
     */
    public function showChoiceOfSectionModal(ChoiceOfSection $choiceOfSection)
    {
        if (!$choiceOfSection instanceof ChoiceOfSection) {
            throw new NotFoundHttpException('Dit keuzedeel is niet gevonden');
        }

        return $this->render('homepage/choiceOfSectionModal.html.twig', [
            'choiceOfSection' => $choiceOfSection,
        ]);
    }
}
