<?php


namespace App\Form;

use App\Entity\Freezer;
use App\Entity\FreezerItem;
use App\Entity\FreezerItemCategory;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class FreezerItemType extends AbstractType
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('description', TextType::class, [
                'attr' => ['placeholder' => 'description'],
                'label' => false,
            ])
            ->add('category', EntityType::class, [
                'placeholder' => 'choose a category',
                'class' => FreezerItemCategory::class,
                'label' => false,
                'choice_label' => 'name',
                'choice_attr' => function($choice, $key, $value) {
                    /** @var FreezerItemCategory $choice */
                    return ['data-default-validity' => $choice->getDefaultValidity()];
                },
                'disabled' => $this->isPersisted($options['data']),
            ])
            ->add('dateExpiry', DateType::class, [
                'label' => 'Expires on',
                'widget' => 'single_text',
                'html5' => true,
            ])
            ->add('quantity', IntegerType::class, [
                'attr' => ['placeholder' => 'quantity'],
                'label' => false,
            ])
            ->add('unit', ChoiceType::class, [
                'choices' => FreezerItem::UNITS,
                'label' => false,
                'disabled' => $this->isPersisted($options['data']),
            ])
        ;
        $user = $this->security->getUser();
        if ($user instanceof User && $user->getHouse()->getFreezers()->count() > 1) {
            $builder->add('freezer', EntityType::class, [
                'class' => Freezer::class,
                'choices' => $user->getHouse()->getFreezers(),
                'choice_label' => 'name',
                'label' => 'move to',
            ]);
        }
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FreezerItem::class,
        ]);
    }

    private function isPersisted(FreezerItem $item)
    {
        return ($item->getId() !== null);
    }
}
