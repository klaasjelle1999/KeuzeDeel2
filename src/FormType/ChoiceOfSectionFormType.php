<?php


namespace App\FormType;


use App\Entity\Category;
use App\Entity\ChoiceOfSection;
use App\Entity\PartOfDay;
use App\Entity\Period;
use App\Entity\Tier;
use App\FormData\ChoiceOfSectionFormData;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChoiceOfSectionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => false,
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => false,
            ])
            ->add('partOfDay', EntityType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'class' => PartOfDay::class,
                'choice_label' => 'partOfDay',
                'label' => false,
            ])
            ->add('tier', EntityType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'class' => Tier::class,
                'choice_label' => 'niveau',
                'label' => false,
            ])
            ->add('contact_hours', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => false,
            ])
            ->add('internship_hours', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => false,
            ])
            ->add('examination', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => false,
            ])
            ->add('cost', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => false,
            ])
        ;
//            ->add('description', TextareaType::class, [
//                'attr' => [
//                    'class' => 'form-control',
//                    'rows' => 20,
//                ],
//                'label' => false,
//            ]);
    }

    public function configureOptions(OptionsResolver $options)
    {
        $options->setDefaults([
            'data_class' => ChoiceOfSectionFormData::class
        ]);
    }
}