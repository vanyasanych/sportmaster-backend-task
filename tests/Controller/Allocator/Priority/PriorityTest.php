<?php

use App\Tests\Controller\Allocator\AbstractAllocatorControllerTest;

class PriorityTest extends AbstractAllocatorControllerTest
{
    public function testCreate()
    {
        $actualData = $this->getActualData();
        dump($actualData);
        dump('!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!');
        $expectedData = $this->expectedData();
        dump($expectedData);
        for ($i = 0; $i < count($expectedData); $i++) {
            $this->assertSame($expectedData[$i]['product_id'], $actualData[$i]['product_id']);
            $this->assertSame($expectedData[$i]['delivery_count'], $actualData[$i]['delivery_count']);
            $expectedResponsibleStores = $expectedData[$i]['responsible_stores'];
            $actualResponsibleStores = $actualData[$i]['responsible_stores'];
            $this->assertEquals($expectedResponsibleStores, $actualResponsibleStores);
        }

    }

    public function expectedData(): array
    {
        return [
            [
                'product_id' => 1,
                'delivery_count' => 3,
                'responsible_stores' => [
                    [
                        'id' => 2,
                    ],
                    [
                        'id' => 3,
                    ]
                ],
            ],
            [
                'product_id' => 2,
                'delivery_count' => 4,
                'responsible_stores' => [
                    [
                        'id' => 1,
                    ],
                    [
                        'id' => 2,
                    ]
                ],
            ],
            [
                'product_id' => 3,
                'delivery_count' => 2,
                'responsible_stores' => [
                    [
                        'id' => 2,
                    ],
                ],
            ],
            [
                'product_id' => 4,
                'delivery_count' => 15,
                'responsible_stores' => [
                    [
                        'id' => 4,
                    ],
                    [
                        'id' => 5,
                    ],
                    [
                        'id' => 6,
                    ],
                ],
            ],
        ];
    }

    public function requestedCartData(): array
    {
        return [
            'product_groups' => [
                [
                    'product_id' => 1,
                    'product_count' => 3,

                ],
                [
                    'product_id' => 2,
                    'product_count' => 4,

                ],
                [
                    'product_id' => 3,
                    'product_count' => 2,

                ],
                [
                    'product_id' => 4,
                    'product_count' => 15,

                ],
                [
                    'product_id' => 5,
                    'product_count' => 1,
                ],
            ]
        ];
    }


    public function requestedInventoriesData(): array
    {
        return [
            [
                'product_id' => 1,
                'store_id' => 2,
                'quantity' => 1,

            ],
            [
                'product_id' => 1,
                'store_id' => 3,
                'quantity' => 2,
            ],
            [
                'product_id' => 1,
                'store_id' => 4,
                'quantity' => 10,
            ],
            [
                'product_id' => 2,
                'store_id' => 1,
                'quantity' => 2,
            ],
            [
                'product_id' => 2,
                'store_id' => 2,
                'quantity' => 3,
            ],
            [
                'product_id' => 3,
                'store_id' => 2,
                'quantity' => 10,
            ],
            [
                'product_id' => 3,
                'store_id' => 6,
                'quantity' => 10,
            ],
            [
                'product_id' => 4,
                'store_id' => 4,
                'quantity' => 4,
            ],
            [
                'product_id' => 4,
                'store_id' => 5,
                'quantity' => 5,
            ],
            [
                'product_id' => 4,
                'store_id' => 6,
                'quantity' => 6,
            ],

        ];
    }

    /**
     * @return array[]
     */
    public function requestedProductsData(): array
    {
        return [
            [
                'sdk' => 1,
                'sku' => '1',
            ],
            [
                'sdk' => 2,
                'sku' => '2',
            ],
            [
                'sdk' => 3,
                'sku' => '3',
            ],
            [
                'sdk' => 4,
                'sku' => '4',
            ],
            [
                'sdk' => 5,
                'sku' => '5',
            ],
        ];
    }

    public function requestedStoresData(): array
    {
        return [
            [
                'name' => 'Store 1',
                'priority' => 1,
            ],
            [
                'name' => 'Store 2',
                'priority' => 2,
            ],
            [
                'name' => 'Store 3',
                'priority' => 3,
            ],
            [
                'name' => 'Store 4',
                'priority' => 4,
            ],
            [
                'name' => 'Store 5',
                'priority' => 5,
            ],
            [
                'name' => 'Store 6',
                'priority' => 6,
            ],
        ];
    }
}