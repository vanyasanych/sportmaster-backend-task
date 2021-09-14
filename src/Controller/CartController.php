<?php

namespace App\Controller;

use App\DTO\Request\CartRequest;
use App\Facade\CartFacade;
use App\Form\CartRequestFormType;
use App\Service\ResponseManager\CartResponseManager;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Rest\Route("carts")
 */
class CartController extends AbstractController
{

    /**
     * @var CartResponseManager
     */
    private CartResponseManager $cartResponseManager;

    /**
     * @var CartFacade
     */
    private CartFacade $cartFacade;

    /**
     * @var FormFactoryInterface
     */
    private FormFactoryInterface $formFactory;

    /**
     * @param CartResponseManager $cartResponseManager
     * @param CartFacade $cartFacade
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(
        CartResponseManager $cartResponseManager,
        CartFacade $cartFacade,
        FormFactoryInterface $formFactory
    ) {
        $this->cartResponseManager = $cartResponseManager;
        $this->cartFacade = $cartFacade;
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
        $cartRequest = new CartRequest();

        $form = $this->formFactory->createNamed('', CartRequestFormType::class, $cartRequest);

        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return View::create($form, Response::HTTP_BAD_REQUEST);
        }

        $cart = $this->cartFacade->createByRequest($cartRequest);

        return $this->cartResponseManager->createView($cart, Response::HTTP_CREATED);
    }
}
