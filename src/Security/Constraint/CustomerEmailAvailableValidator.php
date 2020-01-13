<?php

namespace App\Security\Constraint;

use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CustomerEmailAvailableValidator extends ConstraintValidator
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function validate($value, Constraint $constraint): void
    {
        $customerRepo = $this->entityManager->getRepository(Customer::class);
        $customerByValue = $customerRepo->findOneBy(['email' => $value]);
        if($customerByValue !== null)
        {
            $this->context->buildViolation('The email address is already in use!')
                ->setParameter('{{ string }}', $value)->setInvalidValue($value)->addViolation();
        }
    }
}