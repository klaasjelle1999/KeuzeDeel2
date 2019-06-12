<?php


namespace App\FormType;


use App\Entity\Category;
use App\Entity\PartOfDay;
use App\Entity\Tier;
use App\FormData\UpdateChoiceOfSectionFormData;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateChoiceOfSectionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'autofocus' => true,
                ],
                'label' => false,
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => false,
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'name' => 'editor1',
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
        ;
    }

    public function configureOptions(OptionsResolver $options)
    {
        $options->setDefaults([
            'data_class' => UpdateChoiceOfSectionFormData::class,
        ]);
    }
}