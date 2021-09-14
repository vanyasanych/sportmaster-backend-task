<?php

namespace App\Controller;

use App\DTO\Request\InventoryRequest;
use App\Facade\InventoryFacade;
use App\Form\InventoryRequestFormType;
use App\Service\ResponseManager\InventoryResponseManager;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Rest\Route("inventories")
 */
class InventoryController extends AbstractController
{
    /**
     * @var InventoryResponseManager
     */
    private InventoryResponseManager $inventoryResponseManager;

    /**
     * @var InventoryFacade
     */
    private InventoryFacade $inventoryFacade;

    /**
     * @var FormFactoryInterface
     */
    private FormFactoryInterface $formFactory;

    /**
     * @param InventoryResponseManager $inventoryResponseManager
     * @param InventoryFacade $inventoryFacade
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(
        InventoryResponseManager $inventoryResponseManager,
        InventoryFacade $inventoryFacade,
        FormFactoryInterface $formFactory
    ) {
        $this->inventoryResponseManager = $inventoryResponseManager;
        $this->inventoryFacade = $inventoryFacade;
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
        $inventoryRequest = new InventoryRequest();

        $form = $this->formFactory->createNamed('', InventoryRequestFormType::class, $inventoryRequest);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return View::create($form, Response::HTTP_BAD_REQUEST);
        }

        $inventory = $this->inventoryFacade->createByRequest($inventoryRequest);

        return $this->inventoryResponseManager->createView($inventory, Response::HTTP_CREATED);
    }
}
