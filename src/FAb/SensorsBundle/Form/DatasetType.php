<?php

namespace FAb\SensorsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DatasetType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name')
                ->add('description')
                ->add('station', EntityType::class, array(
                    'class' => 'SensorsBundle:Station',
                    'choices' => function ($station) {
                        return $station->getName();
                    },
                    'label' => 'Station : ',
                ))
        ;
        //->add('station');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'FAb\SensorsBundle\Entity\Dataset'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'fab_sensorsbundle_dataset';
    }

}
