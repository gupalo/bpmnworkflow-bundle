<?php

namespace Gupalo\BpmnWorkflowBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BpmnType extends AbstractType
{
    private const DEF_XML = <<<EOD
        <?xml version="1.0" encoding="UTF-8"?>
        <bpmn2:definitions xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:bpmn2="http://www.omg.org/spec/BPMN/20100524/MODEL" xmlns:bpmndi="http://www.omg.org/spec/BPMN/20100524/DI" xmlns:dc="http://www.omg.org/spec/DD/20100524/DC" xmlns:di="http://www.omg.org/spec/DD/20100524/DI" xsi:schemaLocation="http://www.omg.org/spec/BPMN/20100524/MODEL BPMN20.xsd" id="sample-diagram" targetNamespace="http://bpmn.io/schema/bpmn">
          <bpmn2:process id="Process_1" isExecutable="false">
          </bpmn2:process>
          <bpmndi:BPMNDiagram id="BPMNDiagram_1">
            <bpmndi:BPMNPlane id="BPMNPlane_1" bpmnElement="Process_1">
            </bpmndi:BPMNPlane>
          </bpmndi:BPMNDiagram>
        </bpmn2:definitions>
    EOD;

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'attr' => [
                'style' => 'display: none; height: 350px',
                'class' => 'form-control bpmn'
            ],
            'empty_data' => self::DEF_XML,
            'hide_element_actions' => null
        ]);

        $resolver->setAllowedTypes('hide_element_actions', ['null', 'array']);
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['hide_element_actions'] = $options['hide_element_actions'];
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventListener(FormEvents::POST_SET_DATA, static function(FormEvent $event) {
            $entity = $event->getData();
            $form = $event->getForm();

            if (!$entity) {
                $form->setData(self::DEF_XML);
            }
        });
    }

    public function getParent(): string
    {
        return TextareaType::class;
    }
}
