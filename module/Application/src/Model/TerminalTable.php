<?php
namespace Application\Model;

use RuntimeException;
use Laminas\Db\TableGateway\TableGatewayInterface;

class TerminalTable
{
    private $tableGateway;

    private $entityManager;
    
    public function __construct(TableGatewayInterface $tableGateway)
    {
        // Get Doctrine entity manager
        $this->entityManager = $container->get('doctrine.entitymanager.orm_default');   
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getTerminal($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function saveTerminal(Terminal $terminal)
    {
        $data = [
            'artist' => $terminal->mac,
            'title'  => $terminal->ip,
        ];

        $id = (int) $terminal->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        try {
            $this->getTerminal($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Cannot update terminal with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteTerminal($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}