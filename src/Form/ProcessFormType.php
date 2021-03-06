<?php

namespace Gupalo\BpmnWorkflowBundle\Form;

use Gupalo\BpmnWorkflowBundle\Entity\Process;
use Gupalo\BpmnWorkflowBundle\Form\Type\BpmnType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProcessFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name'
            ])
            ->add('slug', TextType::class, [
                'label' => 'Slug'
            ])
            ->add('xml', BpmnType::class, [
                'hide_element_actions' => [
                    'create.subprocess-expanded',
                    'create.data-object',
                    'create.data-store',
                    'create.participant-expanded',
                    'create.group'
                ]
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Process::class
        ]);
    }
}
