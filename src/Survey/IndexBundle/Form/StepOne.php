<?php
namespace Survey\IndexBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StepOne extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('firstName', 'text',
            array( 'required' => false, 'label' => 'First Name' )
        );
        $builder->add('lastName', 'text',
            array( 'required' => false, 'label' => 'Last Name' )
        );
        $builder->add('email', 'text',
            array( 'required' => false, 'label' => 'Email address' )
        );
        $builder->add('birthday', 'date',
            array(
                'label' => 'Birthday',
                'required' => false,
                'empty_value' => array('year' => 'Year', 'month' => 'Month', 'day' => 'Day'),
                'years' => range(1980, date("Y"))
            )
        );
        $builder->add('shoeSize', 'text',
            array( 'required' => false, 'label' => 'Shoe size' )
        );
    }

    public function getName()
    {
        return 'stepOne';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Survey\IndexBundle\Entity\Users',
            'csrf_protection'   => false,
            'validation_groups' => array('registration')
        ));
    }
}