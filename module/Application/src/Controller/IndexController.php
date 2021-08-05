<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Log\Writer\Stream;
use Laminas\Log\Logger;
use Laminas\View\Model\ViewModel;
use Interop\Container\ContainerInterface;

use Application\Form\TerminalForm;
use Application\Model\Terminal;

class IndexController extends AbstractActionController
{
    
    private $container;
    private $logger;
    
    public function __construct(ContainerInterface $container) {
        $this->container=$container;
        $writer = new Stream('var/log/output_php.log');
        $this->logger = new Logger();
        $this->logger->addWriter($writer);
    }
    
    public function indexAction()
    {
        $form = new TerminalForm();
        $form->get('submit')->setValue('Add');
        
        $request = $this->getRequest();

        $site_name = $this->container->get('config')['site_name'];
        if (! $request->isPost()) {
            return ['form' => $form,'title' => $site_name];
        }

        return new ViewModel();
    }
    
    public function addAction(){
        
        $form = new TerminalForm();
        $form->get('submit')->setValue('Add');
        
         $request = $this->getRequest();

         $site_name = $this->container->get('config')['site_name'];
        if (! $request->isPost()) {
            return ['form' => $form,'title' => $site_name];
        }

        $terminal = new Terminal();
        $form->setInputFilter($terminal->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form,'title' => $site_name];
        }

        $terminal->exchangeArray($form->getData());
        
        
        return $this->redirect()->toRoute('home');
    }
}
