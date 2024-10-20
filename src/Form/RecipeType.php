<?php


namespace App\Form;


use App\Entity\Recipe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'maxlength' => 200,
                    'placeholder' => 'title',
                ],
                'label' => false,
            ])
            ->add('type', EntityType::class, [
                'placeholder' => 'choose a type',
                'class' => \App\Entity\RecipeType::class,
                'label' => false,
                'choice_label' => 'name',
            ])
            ->add('details', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'description',
                    'rows' => 10,
            ],
                'label' => false,
                'required' => false,
            ])
            ->add('url', UrlType::class, [
                'required' => false,
                'label' => false,
                'attr' => ['placeholder' => 'url to the recipe'],
            ])
//            ->add('tags', CollectionType::class, [
//                'entry_type' => TagsType::class,
//                'entry_options' => [
//                    'required' => false,
//                ],
//                'allow_add' => true,
//                'allow_delete' => true,
//                'delete_empty' => true,
//            ])
            ->add('comments', TextareaType::class, [
                'attr' => [
                    'rows' => 6,
                    'placeholder' => 'Comments about the recipe. For instance you may explain that you reduce sugar by 20% if you add dry fruits to the cake'
                ],
                'label' => false,
                'required' => false,
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
