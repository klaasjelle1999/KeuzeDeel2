<?php

namespace App\Controller;

use App\Entity\ChoiceOfSection;
use App\FormType\FilterFormType;
use phpDocumentor\Reflection\DocBlock\Description;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $choiceOfSections = $this->getDoctrine()->getRepository(ChoiceOfSection::class)->findNonDeletedChoiceOfSections();
        $form = $this->createForm(FilterFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            if ($data->category->getId() !== 1 && $data->partOfDay->getId() !== 1 && $data->tier->getId() !== 1 && $data->period->getId() === 1) {
                $choiceOfSections = $this
                    ->getDoctrine()
                    ->getRepository(ChoiceOfSection::class)
                    ->filterChoiceOfSections($data->category, $data->partOfDay, $data->tier)
                ;
            } elseif ($data->category->getId() !== 1 && $data->tier->getId() !== 1 && $data->partOfDay->getId() === 1 && $data->period->getId() === 1) {
                $choiceOfSections = $this
                    ->getDoctrine()
                    ->getRepository(ChoiceOfSection::class)
                    ->filterChoiceOfSectionsV2($data->category, $data->tier)
                ;
            } elseif ($data->partOfDay->getId() !== 1 && $data->tier->getId() !== 1 && $data->category->getId() === 1 && $data->period->getId() === 1) {
                $choiceOfSections = $this
                    ->getDoctrine()
                    ->getRepository(ChoiceOfSection::class)
                    ->filterChoiceOfSectionsV3($data->partOfDay, $data->tier)
                ;
            } elseif ($data->category->getId() !== 1 && $data->partOfDay->getId() !== 1 && $data->tier->getId() === 1 && $data->period->getId() === 1) {
                $choiceOfSections = $this
                    ->getDoctrine()
                    ->getRepository(ChoiceOfSection::class)
                    ->filterChoiceOfSectionsV4($data->category, $data->partOfDay)
                ;
            } elseif ($data->partOfDay->getId() !== 1 && $data->tier->getId() === 1 && $data->category->getId() === 1 && $data->period->getId() === 1) {
                $choiceOfSections = $this
                    ->getDoctrine()
                    ->getRepository(ChoiceOfSection::class)
                    ->filterChoiceOfSectionsV6($data->partOfDay)
                ;
            } elseif ($data->category->getId() !== 1 && $data->partOfDay->getId() === 1 && $data->tier->getId() === 1 && $data->period->getId() === 1) {
                $choiceOfSections = $this
                    ->getDoctrine()
                    ->getRepository(ChoiceOfSection::class)
                    ->filterChoiceOfSectionsV7($data->category)
                ;
            } elseif ($data->category->getId() !== 1 && $data->partOfDay->getId() === 1 && $data->tier->getId() !== 1 && $data->period->getId() !== 1) {
                $choiceOfSections = $this
                    ->getDoctrine()
                    ->getRepository(ChoiceOfSection::class)
                    ->filterChoiceOfSectionsV9($data->category, $data->period)
                ;
            } elseif ($data->category->getId() !== 1 && $data->partOfDay->getId() !== 1 && $data->tier->getId() !== 1 && $data->period->getId() !== 1) {
                $choiceOfSections = $this
                    ->getDoctrine()
                    ->getRepository(ChoiceOfSection::class)
                    ->filterChoiceOfSectionsV8($data->category, $data->partOfDay, $data->tier, $data->period)
                ;
            } elseif ($data->category->getId() === 1 && $data->partOfDay->getId() !== 1 && $data->tier->getId() === 1 && $data->period->getId() !== 1) {
                $choiceOfSections = $this
                    ->getDoctrine()
                    ->getRepository(ChoiceOfSection::class)
                    ->filterChoiceOfSectionsV10($data->partOfDay, $data->period)
                ;
            } elseif ($data->category->getId() === 1 && $data->partOfDay->getId() === 1 && $data->tier->getId() !== 1 && $data->period->getId() !== 1) {
                $choiceOfSections = $this
                    ->getDoctrine()
                    ->getRepository(ChoiceOfSection::class)
                    ->filterChoiceOfSectionsV11($data->tier, $data->period)
                ;
            } elseif ($data->category->getId() === 1 && $data->partOfDay->getId() === 1 && $data->tier->getId() === 1 && $data->period->getId() !== 1) {
                $choiceOfSections = $this
                    ->getDoctrine()
                    ->getRepository(ChoiceOfSection::class)
                    ->filterChoiceOfSectionsV12($data->period)
                ;
            } elseif ($data->category->getId() === 1 && $data->partOfDay->getId() !== 1 && $data->tier->getId() !== 1 && $data->period->getId() !== 1) {
                $choiceOfSections = $this
                    ->getDoctrine()
                    ->getRepository(ChoiceOfSection::class)
                    ->filterChoiceOfSectionsV13($data->partOfDay, $data->tier, $data->period)
                ;
            } elseif ($data->category->getId() !== 1 && $data->partOfDay->getId() !== 1 && $data->tier->getId() === 1 && $data->period->getId() !== 1) {
                $choiceOfSections = $this
                    ->getDoctrine()
                    ->getRepository(ChoiceOfSection::class)
                    ->filterChoiceOfSectionsV14($data->category, $data->partOfDay, $data->period);
            } elseif ($data->tier->getId() !== 1 && $data->category->getId() === 1 && $data->partOfDay->getId() === 1 && $data->period->getId() === 1) {
                $choiceOfSections = $this
                    ->getDoctrine()
                    ->getRepository(ChoiceOfSection::class)
                    ->filterChoiceOfSectionsV5($data->tier)
                ;
            } elseif ($data->category->getId() !== 1 && $data->partOfDay->getId() === 1 && $data->tier->getId() !== 1 && $data->period->getId() !== 1) {
                $choiceOfSections = $this
                    ->getDoctrine()
                    ->getRepository(ChoiceOfSection::class)
                    ->filterChoiceOfSectionsV15($data->category, $data->tier, $data->period)
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
