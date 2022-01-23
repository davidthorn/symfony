<?php

namespace App\Form\Types;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * An abstraction layer for the AbstractType that provides some helper methods to reduce copy duplication.
 *
 */
abstract class AbstractCompoundType extends AbstractType
{
    /**
     * Implements the required buildForm method from AbstractType, but adds two help methods that
     * can be overridden to execute code when specific form events have occurred.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) use($options) {
            $this->onSubmit($event, $options);
        });

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) use($options) {
            $this->onPreSubmit($event, $options);
        });

        parent::buildForm($builder, $options);
    }

    /**
     * Called in the event listener for FormEvents::PRE_SUBMIT
     *
     * @param FormEvent $event
     * @param array $options
     */
    public function onPreSubmit(FormEvent $event, array $options)
    {
        // Override this method to utilise this method.
    }

    /**
     * Called in the event listener for FormEvents::SUBMIT
     *
     * @param FormEvent $event
     * @param array $options
     */
    public function onSubmit(FormEvent $event, array $options)
    {
        // Override this method to utilise this method.
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'compound' => false
        ]);
    }
}