<?php

namespace App\Security;

use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginCustomerFormAuthenticator extends AbstractFormLoginAuthenticator
{
    use TargetPathTrait;

    private $entityManager;
    private $router;
    private $csrfTokenManager;
    private $passwordEncoder;
    public const REQUEST_PARAMETER = 'customer_login';
    public const SESSION_PARAMETER = Security::AUTHENTICATION_ERROR . '.' . self::REQUEST_PARAMETER;
    public const LAST_USERNAME = Security::LAST_USERNAME . '.' . self::REQUEST_PARAMETER;
    private $errorArray;

    public function __construct(EntityManagerInterface $entityManager, RouterInterface $router,
                                CsrfTokenManagerInterface $tokenManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->router = $router;
        $this->csrfTokenManager = $tokenManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->errorArray = [];
    }

    public function supports(Request $request): bool
    {
        return ('index' === $request->attributes->get('_route') &&
            $request->isMethod('POST') &&
            $request->request->get(self::REQUEST_PARAMETER) !== null);
    }

    protected function getLoginUrl(): string
    {
        return $this->router->generate('index');
    }

    public function getCredentials(Request $request)
    {
        $credentials = [
            'email' => $request->request->get('customer_login')['email'],
            'password' => $request->request->get('customer_login')['password'],
            'csrf_token' => $request->request->get('customer_login')['_csrf_token'],
        ];

        $request->getSession()->set(self::LAST_USERNAME, $credentials['email']);

        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider): Object
    {
        $token = new CsrfToken('login_customer', $credentials['csrf_token']);
        if(!$this->csrfTokenManager->isTokenValid($token))
        {
            throw new InvalidCsrfTokenException();
        }

        $user = $this->entityManager->getRepository(Customer::class)->findOneBy(['email' => $credentials['email']]);
        if(!$user)
        {
            array_push($this->errorArray, new FormError('Email is not registered!', null, ['email']));
            throw new AuthenticationException();
        }

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user): bool
    {
        $result = $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
        if(!$result)
        {
            array_push($this->errorArray, new FormError('Wrong password!', null, ['password']));
        }
        return $result;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey): Response
    {
        return new RedirectResponse($this->router->generate('index'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        if($request->hasSession())
        {
            $request->getSession()->set(self::SESSION_PARAMETER,
                $this->errorArray);
        }
        $url = $this->getLoginUrl();
        return new RedirectResponse($url);
    }
}