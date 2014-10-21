<?php

namespace WSP\SecondBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use WSP\SecondBundle\Service\JamDuplicateService;

class JamAdmin extends Admin
{
    const FIELD_AMOUNT = 'amount';

    /** @var string route */
    protected $baseRoutePattern = 'jam';

    /** @var JamDuplicateService */
    protected $jamService;

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('type', 'entity', array('class' => 'WSP\SecondBundle\Entity\JamType', 'property' => 'name'))
            ->add('year', 'entity', array('class' => 'WSP\SecondBundle\Entity\JamProductionYear', 'property' => 'year'))
            ->add('description')
        ;
        $subject = $this->getSubject();
        if (!$subject->getId()) {
            $formMapper->add(static::FIELD_AMOUNT, 'integer', array(
                'mapped' => false,
                'data' => 1,
                'attr' => array('min' => 1),
            ));
        }
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('type.name')
            ->add('year.year')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('type.name')
            ->add('year.year')
            ->add('description')
        ;
    }

    /**
     * JamService setter for DI
     *
     * @param JamDuplicateService $jamService
     */
    public function setJamService(JamDuplicateService $jamService)
    {
        $this->jamService = $jamService;
    }

    /**
     * @inheritdoc
     */
    public function postPersist($entity)
    {
        $form = $this->getForm();
        if ($form->offsetExists(static::FIELD_AMOUNT)) {
            $amount = intval($form->get(static::FIELD_AMOUNT)->getData());
            $this->jamService->duplicate($entity, $amount - 1);
        }
    }
}
