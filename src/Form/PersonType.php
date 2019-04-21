<?php

namespace App\Form;

use App\Entity\Person;
use App\Entity\Sex;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Templating\GlobalVariables;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $id = $options['person_id'];
        $builder
            ->add('name')
            ->add('sex')
            ->add('age')
            ->add('father', EntityType::class, [
                'class' => Person::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) use ($id) {
                    return $er->createQueryBuilder('m')
                        ->andWhere('m.sex = :sex')
                        ->setParameter('sex', 1)
                        ->andWhere('m.id != :id')
                        ->setParameter('id', $id)
                        ->orderBy('m.name', 'ASC');
                }
            ])
            ->add('mother', EntityType::class, [
                'class' => Person::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) use ($id) {
                    return $er->createQueryBuilder('f')
                        ->andWhere('f.sex = :sex')
                        ->setParameter('sex', 2)
                        ->andWhere('f.id != :id')
                        ->setParameter('id', $id)
                        ->orderBy('f.name', 'ASC');
                }
            ])
            ->add('sex', EntityType::class, [
                'class' => Sex::class,
                'choice_label' => 'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Person::class,
            'person_id' => 0
        ]);
    }
}
