<?php

namespace Innonic\JobBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class JobType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        $categories = $this->getDoctrine()->getRepository('JobBundle:Category')->findAll();
//        $categoryChoices = array();
//        foreach ($categories as $category) {
//            $categoryChoices[$category->getId()] = $category->getCategory();
//        }

        $builder->add('title')
                ->add('type')
                ->add('position')
                ->add('location')
                ->add('description')
                ->add('application')
                ->add('email')
                ->add('company')
                ->add('category', 'entity', array(
                        'class'  => 'JobBundle:Category',
                        'query_builder' => function(\Doctrine\ORM\EntityRepository $er) {
                            return $er->createQueryBuilder('category')
                                        ->orderBy('category.id', 'ASC');
                        },
                        'choice_label' => 'category'
                    )
                );
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Innonic\JobBundle\Entity\Job'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'innonic_jobbundle_job';
    }


}
