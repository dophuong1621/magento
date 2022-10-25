<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\Testimonial\Block\Adminhtml\Testimonial\Edit;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Store\Model\System\Store;
use Tigren\Testimonial\Model\Testimonial;

/**
 * Class Form
 * @package Tigren\Testimonial\Block\Adminhtml\Testimonial\Edit
 */
class Form extends Generic
{

    /**
     * @var Store
     */
    protected $_systemStore;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry             $registry,
        \Magento\Framework\Data\FormFactory     $formFactory,
        Store                                   $systemStore,
        array                                   $data = []
    )
    {
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Init form
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('testimonial_form');
        $this->setTitle(__('Testimonial Information'));
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var Testimonial $model */
        $model = $this->_coreRegistry->registry('testimonial_testimonial');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post']]
        );

        $form->setHtmlIdPrefix('testimonial_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('General Information'), 'class' => 'fieldset-wide']
        );

        if ($model->getId()) {
            $fieldset->addField('entity_id', 'hidden', ['name' => 'entity_id']);
        }

        $fieldset->addField(
            'name',
            'text',
            ['name' => 'name', 'label' => __('Testimonial Name'), 'title' => __('Testimonial Name'), 'required' => true]
        );

        $fieldset->addField(
            'email',
            'text',
            ['name' => 'email', 'label' => __('Testimonial Email'), 'title' => __('Testimonial Email'), 'required' => true]
        );
//
//        $fieldset->addField(
//            'message',
//            'text',
//            ['name' => 'message', 'label' => __('Testimonial Message'), 'title' => __('Testimonial Message'), 'required' => true]
//        );
//
//        $fieldset->addField(
//            'company',
//            'text',
//            ['name' => 'company', 'label' => __('Testimonial Company'), 'title' => __('Testimonial Company'), 'required' => true]
//        );
//
//        $fieldset->addField(
//            'rating',
//            'int',
//            ['name' => 'rating', 'label' => __('Testimonial Rating'), 'title' => __('Testimonial Rating'), 'required' => true]
//        );
//
//        $fieldset->addField(
//            'profile_image',
//            'varchar',
//            ['name' => 'profile_image', 'label' => __('Testimonial Profile Image'), 'title' => __('Testimonial Profile Image'), 'required' => true]
//        );
//
//        $fieldset->addField(
//            'status',
//            'int',
//            ['name' => 'status', 'label' => __('Testimonial Status'), 'title' => __('Testimonial Status'), 'required' => true]
//        );

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
