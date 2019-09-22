<?php


namespace App\Form;


use App\Entity\Dinner;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class DinnerType
 *
 * @package App\Form
 */
class DinnerType extends MealType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Dinner::class,
        ]);
    }
}
