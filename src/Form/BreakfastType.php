<?php


namespace App\Form;


use App\Entity\Breakfast;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class BreakfastType
 *
 * @package App\Form
 */
class BreakfastType extends MealType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Breakfast::class,
        ]);
    }
}
