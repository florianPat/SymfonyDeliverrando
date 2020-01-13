<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestMatcherInterface;
use Symfony\Component\Security\Core\Security;

class CustomerRequestMatcher implements RequestMatcherInterface
{
    /**
     * @inheritDoc
     */
    public function matches(Request $request): bool
    {
        return $request->request->get(LoginCustomerFormAuthenticator::REQUEST_PARAMETER) !== null ||
           $request->getSession()->get(LoginCustomerFormAuthenticator::LAST_USERNAME) !== null;
    }
}