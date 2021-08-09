<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Log\Writer\Stream;
use Laminas\Log\Logger;
use Laminas\View\Model\ViewModel;
use Interop\Container\ContainerInterface;

use Application\Form\TerminalForm;
use Application\Entity\Terminal;

class IndexController extends AbstractActionController
{
    
    private $container;
    private $entityManager;
    
    private $logger;
    
    public function __construct(ContainerInterface $container) {
        $this->container=$container;
        $writer = new Stream('var/log/output_php.log');
        $this->logger = new Logger();
        $this->logger->addWriter($writer);
        $this->entityManager = $container->get('doctrine.entitymanager.orm_default');
    }
    
    public function indexAction()
    {
        $form = new TerminalForm();
        $form->get('submit')->setValue('Add');
        
        $request = $this->getRequest();

        $site_name = $this->container->get('config')['site_name'];
        
        $terminalRepository= $this->entityManager->getRepository(Terminal::class);
        $terminals= $terminalRepository->findAll();
        
        if (! $request->isPost()) {
            return ['form' => $form,'title' => $site_name,'terminals' => $terminals];
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
        
        $this->entityManager->persist($terminal);
        // Apply changes to database.
        $this->entityManager->flush();
        
        return $this->redirect()->toRoute('home');
    }
    
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('home');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $terminalRepository = $this->entityManager->getRepository(Terminal::class);
                $terminal = $terminalRepository->findOneById($id);
                if($terminal == null){
                  return $this->redirect()->toRoute('home');
                }
                 $this->entityManager->remove($terminal);
                 $this->entityManager->flush();
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('home');
        }

        return [
            'id'    => $id,
            'terminal' => $this->entityManager->getRepository(Terminal::class)->findOneById($id),
        ];
    }
}
