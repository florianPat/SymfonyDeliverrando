<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\Product;
use App\Entity\User;
use App\Form\CreateProductType;
use App\Form\CustomerLoginType;
use App\Form\CustomerRegisterType;
use App\Security\LoginCustomerFormAuthenticator;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class StoreInventoryController extends DefaultLayoutBaseController
{
    private $session;
    private $passwordEncoder;

    public function __construct(SessionInterface $session, UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct();

        $this->session = $session;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/", name="index")
     */
    public function index(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        $productRepository = $this->getDoctrine()->getRepository(Product::class);

        $customerLoginFormView = null;
        $createProductForm = $this->handleProductForm($request);
        if(!$this->getUser())
        {
            $customerLoginFormView = $this->handleCustomerLoginForm($request)->createView();
        }
        $customerRegisterForm = $this->handleCustomerRegisterForm($request);

        return $this->render('index.html.twig', [
                'products' => $productRepository->findAll(),
                'createProductForm' => $createProductForm->createView(),
                'customerLoginForm' => $customerLoginFormView,
                'customerRegisterForm' => $customerRegisterForm->createView(),
                'error' => $authenticationUtils->getLastAuthenticationError(),
                'last_username' => $this->getLastAdminUsername($request),
                'firewall_context' => $request->attributes->get('_firewall_context'),
            ]
        );
    }

    private function getLastCustomerUsername(Request $request): string
    {
        return $this->getAndDeleteFromSession($request, LoginCustomerFormAuthenticator::LAST_USERNAME, '');
    }

    private function getLastAdminUsername(Request $request): string
    {
        return $this->getAndDeleteFromSession($request, Security::LAST_USERNAME, '');
    }

    private function getAndDeleteFromSession(Request $request, string $name, $default)
    {
        if($request->hasSession())
        {
            $result = $request->getSession()->get($name, null);
            if($result !== null)
            {
                $request->getSession()->remove($name);
                return $result;
            }
            else
            {
                return $default;
            }
        }

        return $default;
    }

    public function handleProductForm(Request $request): FormInterface
    {
        $createProduct = new Product();
        $form = $this->createForm(CreateProductType::class, $createProduct);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $createProduct->setQuantity(10);
            $this->addProduct($createProduct);
        }

        return $form;
    }

    public function handleCustomerLoginForm(Request $request): FormInterface
    {
        $customer = new Customer();
        $formErrors = $this->getAndDeleteFromSession($request, LoginCustomerFormAuthenticator::SESSION_PARAMETER, null);
        $options = ['value' => $this->getLastCustomerUsername($request)];
        $form = $this->createForm(CustomerLoginType::class, $customer, $options);
        if($formErrors !== null)
        {
            foreach($formErrors as $formError)
            {
                $form->addError($formError);
            }
        }

        return $form;
    }

    public function handleCustomerRegisterForm(Request $request): FormInterface
    {
        $customer = new Customer();
        $form = $this->createForm(CustomerRegisterType::class, $customer);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $encodedPassword = $this->passwordEncoder->encodePassword($customer, $customer->getPassword());
            $customer->setPassword($encodedPassword);
            $docManager = $this->getDoctrine()->getManager();
            $docManager->persist($customer);
            $docManager->flush();

            // return $guardHandler->authenticateUserAndHandleSuccess($customer, $request, LoginCustomerFormAuthenticator, 'deliverrandoCustomer');
        }

        return $form;
    }

    /**
     * @Route("/remove/{product}", name="remove")
     *
     * IsGranted("ROLE_ADMIN")
     */
    public function remove(Product $product): Response
    {
        $this->addFlash('info', 'Removed the product ' . $product->getName());

        $this->getDoctrine()->getManager()->remove($product);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('index');
    }

    public function addProduct(Product $product): void
    {
        if($this->isGranted('ROLE_ADMIN'))
        {
            $this->addFlash('info', 'Added the product ' . $product->getName());

            $this->getDoctrine()->getManager()->persist($product);
            $this->getDoctrine()->getManager()->flush();
        }
        else
        {
            $this->addFlash('info', 'How did you get here?');
        }
    }
}