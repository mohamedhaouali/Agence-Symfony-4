<?php

namespace App\Form;

use App\Entity\Option;
use App\Entity\Proprety;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropretyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('surface')
            ->add('rooms')
            ->add('bedrooms')
            ->add('floor')
            ->add('price')
            ->add('heat', ChoiceType::class, ['choices' => $this->getChoices()])
            ->add('options',EntityType::class,[
                'class' =>Option::class,
                'choice_label' =>'name',
                'multiple' =>true
                ]
            )
            ->add('city')
            ->add('adress')
            ->add('postal_code')
            ->add('sold');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Proprety::class,
            'translation_domain' => 'forms'
        ]);
    }
    //pour choice type pour qu'il affiche gaz w electrique
    private function getChoices()
    {
        $choices = Proprety::Heat;
        $output = [];
        foreach ($choices as $k => $v){
            $output[$v] = $k;
        }
        return $output;
    }

}
