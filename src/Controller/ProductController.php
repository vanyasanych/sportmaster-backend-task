<?php

namespace App\Controller;

use App\DTO\Request\ProductRequest;
use App\Facade\ProductFacade;
use App\Form\ProductRequestFormType;
use App\Service\EntityManager\ProductManager;
use App\Service\ResponseManager\ProductResponseManager;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Rest\Route("products")
 */
class ProductController extends AbstractFOSRestController
{

    /**
     * @var ProductResponseManager
     */
    private ProductResponseManager $productResponseManager;

    /**
     * @var ProductFacade
     */
    private ProductFacade $productFacade;

    /**
     * @var FormFactoryInterface
     */
    private FormFactoryInterface $formFactory;

    /**
     * @param ProductResponseManager $productResponseManager
     * @param ProductFacade $productFacade
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(
        ProductResponseManager $productResponseManager,
        ProductFacade $productFacade,
        FormFactoryInterface $formFactory
    ) {
        $this->productResponseManager = $productResponseManager;
        $this->productFacade = $productFacade;
        $this->formFactory = $formFactory;
    }


    /**
     * @Rest\Post()
     *
     * @param Request $request
     *
     * @return View
     */
    public function create(Request $request): View
    {
        $productRequest = new ProductRequest();

        $form = $this->formFactory->createNamed('', ProductRequestFormType::class, $productRequest);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return View::create($form, Response::HTTP_BAD_REQUEST);
        }

        $product = $this->productFacade->createByRequest($productRequest);

        return $this->productResponseManager->createView($product, Response::HTTP_CREATED);
    }
}
