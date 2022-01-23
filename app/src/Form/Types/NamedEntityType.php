<?php

namespace App\Form\Types;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\NonUniqueResultException;
use Exception;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * The named entity type works similar to the EntityType but, the difference is that
 * it checks if an entity exists with id or name that matches the data in the field.
 *
 */
final class NamedEntityType extends AbstractCompoundType
{
    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param FormEvent $event
     * @param array $options
     * @throws EntityNotFoundException|NonUniqueResultException
     * @throws Exception
     */
    public function onPreSubmit(FormEvent $event, array $options)
    {
        if(!array_key_exists('class', $options)) {
            throw new BadRequestHttpException('The options key class must be set');
        }

        $dataClass = $options['class'];
        $criteria = $event->getData();

        if($criteria === null && $options['required'] == false) {
            return;
        }

        if($criteria === null && $options['required'] == true) {
            throw new Exception(sprintf('The entity %s cannot be validated without criteria', $dataClass));
        }

        $data = $this->entityManager
            ->getRepository($dataClass)
            ->createQueryBuilder('p')
            ->where('LOWER(p.name) = :name')
            ->orWhere('p.id = :id')
            ->setParameter(':id', $criteria)
            ->setParameter(':name', strtolower($criteria))
            ->getQuery()
            ->getOneOrNullResult();

        if ($data === null) {
            throw new EntityNotFoundException(sprintf('The %s "%s" does not exist', $dataClass, $event->getData()));
        }

        $event->setData($data);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => null,
        ]);
        $resolver->addAllowedTypes('class', ['string']);
        parent::configureOptions($resolver);
    }
}