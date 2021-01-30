<?php

namespace App\Dictionary\Service;

use App\Dictionary\Repository\ChangeRepository;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Common\Service\TServiceParameterValidator;
use Symfony\Component\HttpFoundation\Response;
use App\Dictionary\Entity\Change;

class ChangeService {

    use TServiceParameterValidator;

    /**
     * @var ChangeRepository
     */
    private ChangeRepository $repository;

    public function __construct(ChangeRepository $repository) {
        $this->serviceName = 'ChangeService';
        $this->repository = $repository;
    }

    public function create(array $data, UserInterface $user) :Uuid {
        $this->validate($data, [
            'excerpt' => 'required|text',
            'description' => 'required|text',
            '//@todo'
        ]);                        

        $uuid = Uuid::v4();
        $change = new Change($uuid, $data['excerpt'], $data['description']);
        
        $this->repository->create($change);
        return $uuid;
    }


}