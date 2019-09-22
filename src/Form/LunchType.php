<?php


namespace App\Form;


use App\Entity\Lunch;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class LunchType
 *
 * @package App\Form
 */
class LunchType extends MealType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lunch::class,
        ]);
    }
}
