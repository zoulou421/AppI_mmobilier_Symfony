<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('surface')
            ->add('rooms')
            ->add('bedrooms')
            ->add('floor')
            ->add('price')
            ->add('heat', ChoiceType::class,
                   [
                     'choices' =>$this-> getChoices()
                   ]
                 )
            ->add('city', null,['label'=>'Ville']) //On peut traduire autrement avec le traducteur file
            ->add('address')
            ->add('postal_code')
 //           ->add('created_at')
            ->add('sold')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
            'translation_domain' => 'forms'
        ]);
    }

    public function getChoices(){
       $choices = Property::HEAT;
       $output = [];
       foreach ($choices as $k => $v) {
          $output[$v]=$k;
       }
       return $output;
    }
}
