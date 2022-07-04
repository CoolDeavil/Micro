<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 18/02/2019
 * Time: 12:22
 */

namespace API\Validation;

use API\Core\Utils\Translate;
use API\Core\Utils\Validation;
use API\Models\AppUser;
use API\Repository\AuthModelRepository;
use JetBrains\PhpStorm\Pure;

class CheckIfUniqueEmail extends Validation
{

    /**
     * @var Translate
     */
    private $translate;
    /**
     * @var AuthModelRepository
     */
    private $repository;

    #[Pure] public function __construct(Translate $translate, AuthModelRepository $repository)
    {
        parent::__construct($translate);
        $this->translate = $translate;
        $this->repository = $repository;
    }

    public function __invoke($email): ?string
    {
        $user = (new AppUser())
        ->setEmail($email);
        $result = $this->repository->checkIfUniqueEmail($user);
        if ($result !== null) {
            return 'UE ' . $this->lang->translate($result);
        }
        return null;
    }
}
