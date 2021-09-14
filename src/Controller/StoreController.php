<?php

namespace App\Controller;

use App\DTO\Request\StoreRequest;
use App\Facade\StoreFacade;
use App\Form\StoreRequestFormType;
use App\Service\ResponseManager\StoreResponseManager;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Route("stores")
 */
class StoreController extends AbstractFOSRestController
{
    /**
     * @var FormFactoryInterface
     */
    private FormFactoryInterface $formFactory;

    /**
     * @var StoreFacade
     */
    private StoreFacade $storeFacade;

    /**
     * @var StoreResponseManager
     */
    private StoreResponseManager $storeResponseManager;


    /**
     * @param FormFactoryInterface $formFactory
     * @param StoreFacade $storeFacade
     * @param StoreResponseManager $storeResponseManager
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        StoreFacade $storeFacade,
        StoreResponseManager $storeResponseManager
    ) {
        $this->formFactory = $formFactory;
        $this->storeFacade = $storeFacade;
        $this->storeResponseManager = $storeResponseManager;
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
        $storeRequest = new StoreRequest();

        $form = $this->formFactory->createNamed('', StoreRequestFormType::class, $storeRequest);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return View::create($form, Response::HTTP_BAD_REQUEST);
        }

        $store = $this->storeFacade->createByRequest($storeRequest);

        return $this->storeResponseManager->createView($store, Response::HTTP_CREATED);
    }

}