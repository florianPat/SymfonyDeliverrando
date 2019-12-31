<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\CreateProductType;
use Doctrine\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\Object_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class StoreInventoryController extends DefaultLayoutBaseController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request)
    {
        $productRepository = $this->getDoctrine()->getRepository(Product::class);

        $createProduct = new Product();
        $form = $this->createForm(CreateProductType::class, $createProduct);
        $handeldRequest = $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            //if($this->isGranted('ROLE_USER'))
            {
                $createProduct->setQuantity(10);
                $this->addProduct($createProduct);

                //TODO: Add a seperate page for adding products or change the logic
                // so that reloading the page does not trigger a new submission of the form
            }
            /*else
                throw $this->createAccessDeniedException();*/
        }

        return $this->render('index.html.twig', [
            'products' => $productRepository->findAll(),
            'createProductForm' => $form->createView()]);
    }

    /**
     * @Route("/remove/{product}", name="remove")
     *
     * //IsGranted("ROLE_USER")
     */
    public function remove(Product $product)
    {
        $this->addFlash('info', 'Removed the product ' . $product->getName());

        $this->getDoctrine()->getManager()->remove($product);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('index');
    }

    public function addProduct(Product $product): void
    {
        $this->addFlash('info', 'Added the product ' . $product->getName());

        $this->getDoctrine()->getManager()->persist($product);
        $this->getDoctrine()->getManager()->flush();
    }
}