<?php
namespace Survey\IndexBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StepTwo extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('favouriteIceCream', 'text',
            array( 'required' => false, 'label'  => 'What is Your Favorite Ice cream?' )
        );
        $builder->add('favouriteSuperhero', 'text',
            array( 'required' => false, 'label' => 'Who is your favorite superhero?' )
        );
        $builder->add('favouriteMovieStar', 'text',
            array( 'required' => false, 'label' => 'Who is your favorite movie star?' )
        );
        $builder->add('worldEndDate', 'date',
            array(
                'required' => false,
                'input'  => 'datetime',
                'widget' => 'choice',
                'label' => 'When do you think the world will end?',
                'empty_value' => array('year' => 'Year', 'month' => 'Month', 'day' => 'Day'),
                'years' => range(date("Y"), date("Y") + 20),
            )
        );
        $builder->add('superbowlWinner', 'text',
            array( 'required' => false, 'label' => 'Who will win the super bowl this year?' )
        );

        $builder->add('id', 'hidden', array('required' => false));
    }

    public function getName()
    {
        return 'stepTwo';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Survey\IndexBundle\Entity\Users',
                'csrf_protection'   => false,
                'validation_groups' => array('step2')
            )
        );
    }
}