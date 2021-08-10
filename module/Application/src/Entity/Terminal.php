<?php

namespace Application\Entity;

use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\Validator\StringLength;
use Doctrine\ORM\Mapping as ORM;
use Application\Controller\WhiteListAPI;

/**
 * @ORM\Entity
 * @ORM\Table(name="terminal")
 */
class Terminal implements InputFilterAwareInterface {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    public $id;

    /**
     * @ORM\Column(name="mac")  
     */
    public $mac;

    /**
     * @ORM\Column(name="ip")  
     */
    public $ip;

    /**
     * @ORM\Column(name="allowed_access")  
     */
    public $allowed_access;
    
    
    public $inputFilter;

    function getId() {
        return $this->id;
    }

    function getMac() {
        return $this->mac;
    }

    function getIp() {
        return $this->ip;
    }

    function getAllowedAccess() {
        return $this->allowed_access;
        /*if ($this->ip && $this->mac) {
            $allowed = WhiteListAPI::getInstance()->checkMACAddress($this->mac, $this->ip);
            if ($allowed === "1") {
                $this->allowed_access = 'yes';
            } else {
                $this->allowed_access = 'no';
            }
        }
        return $this->allowed_access;*/
    }

    public function exchangeArray(array $data) {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->mac = !empty($data['mac']) ? $data['mac'] : null;
        $this->ip = !empty($data['ip']) ? $data['ip'] : null;
        $this->allowed_access = !empty($data['allowed_access']) ? $data['allowed_access'] : 0;
    }

    // Add the following method:
    public function getArrayCopy() {
        return [
            'id' => $this->id,
            'mac' => $this->mac,
            'ip' => $this->ip,
            'allowed_access' => $this->allowed_access,
        ];
    }

    /* Add the following methods: */

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new DomainException(sprintf(
                                '%s does not allow injection of an alternate input filter',
                                __CLASS__
        ));
    }

    public function getInputFilter() {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'mac',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'ip',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
            ],
        ]);
        

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }

}
