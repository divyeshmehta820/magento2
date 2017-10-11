<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

// @codingStandardsIgnoreFile

namespace Indianic\Adminlog\Block\Adminhtml\User\Edit\Tab;

class Main
{
    /**
     * Get form HTML
     *
     * @return string
     */
    public function aroundGetFormHtml(
        \Magento\User\Block\User\Edit\Tab\Main $subject,
        \Closure $proceed
    )
    {
        $form = $subject->getForm();
        if (is_object($form)) {
            $fieldset = $form->addFieldset('ip', ['legend' => __('Ip Address')]);
            $fieldset->addField(
                'ip_address',
                'text',
                [
                    'name' => 'ip_address',
                    'label' => __('Ip Address'),
                    'id' => 'ip_address',
                    'title' => __('Ip'),
                    'required' => false,
                    'note' => '10.9.2.1'
                ]
            );

            $subject->setForm($form);
        }

        return $proceed();
    }
}