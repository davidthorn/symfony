<?php

namespace App\Controller;

use App\Entity\BasicInfo;
use App\Form\BasicInfoType;
use Doctrine\Persistence\ObjectRepository;

/**
 *
 */
class BasicInfoController extends AbstractRestController
{
    /**
     * @return string
     */
    public function getFormType(): string
    {
        return BasicInfoType::class;
    }

    /**
     * @return string
     */
    public function getEntityType(): string
    {
        return BasicInfo::class;
    }

    /**
     * @return ObjectRepository
     */
    public function getRepository(): ObjectRepository
    {
        return $this->getDoctrine()->getRepository($this->getEntityType());
    }
}
