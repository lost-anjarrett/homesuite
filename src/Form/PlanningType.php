<?php


namespace App\Form;


use App\Entity\Day;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

class PlanningType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('days', CollectionType::class, [
            'entry_type' => DayType::class,
            'entry_options' => [],
            'allow_delete' => true,
            'delete_empty' => function (Day $day) {
                foreach ($day->getMeals() as $meal) {
                    if (!empty($meal->getDescription())) return false;
                };

                return true;
            },
        ]);
    }
}
