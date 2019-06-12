<?php


namespace App\FormType;


use App\Entity\Category;
use App\Entity\PartOfDay;
use App\Entity\Tier;
use App\FormData\FilterFormData;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
                'attr' => [
                    'class' => 'form-control col',
                ],
                'label' => false,
                'choice_value' => function (Category $category = null) {
                    return $category ? $category->getId() : '';
                }
            ])
            ->add('partOfDay', EntityType::class, [
                'class' => PartOfDay::class,
                'choice_label' => 'partOfDay',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.partOfDay', 'ASC');
                },
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => false,
                'choice_value' => function (PartOfDay $partOfDay = null) {
                    return $partOfDay ? $partOfDay->getId() : '';
                }
            ])
            ->add('tier', EntityType::class, [
                'class' => Tier::class,
                'choice_label' => 'niveau',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => false,
                'choice_value' => function (Tier $tier = null) {
                    return $tier ? $tier->getId() : '';
                }
    ])
        ;
    }

    public function configureOptions(OptionsResolver $options)
    {
        $options->setDefaults([
            'data_class' => FilterFormData::class,
        ]);
    }
}