<?php

class Application_Form_Element_AngularSelect extends Zend_Form_Element_Multi
{
    /**
     * 'multiple' attribute
     * @var string
     */
    public $multiple = false;

    /**
     * Use formSelect view helper by default
     * @var string
     */
    public $helper = 'formAngualrSelect';
}
