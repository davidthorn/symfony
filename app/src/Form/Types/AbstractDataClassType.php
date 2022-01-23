<?php

namespace App\Form\Types;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * An AbstractDataClassType should be used for an Entity types.
 */
abstract class AbstractDataClassType extends AbstractType
{
    /**
     * Method should return the data class entity name to be used for the data_class option.
     *
     * @return string
     */
    abstract public function getDataClassEntity(): string;

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => $this->getDataClassEntity()
        ]);
    }
}