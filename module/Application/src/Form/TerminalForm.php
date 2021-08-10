<?php

namespace Application\Form;

use Laminas\Form\Form;

class TerminalForm extends Form
{
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('terminal');
        
        //By default the POST method is used. If you want to change do the following:
        $this->setAttribute('method', 'POST');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'mac',
            'type' => 'text',
            'options' => [
                'label' => 'MAC Address',
            ],
        ]);
        $this->add([
            'name' => 'ip',
            'type' => 'text',
            'options' => [
                'label' => 'IP Address',
            ],
        ]);
        $this->add([
            'name' => 'allowed_access',
            'type' => 'checkbox',
            'options' => [
                'label' => 'Allowed access',
            ],
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
            ],
        ]);
    }
}