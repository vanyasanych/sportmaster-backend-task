<?php

namespace App\Tests\Controller\Allocator\Random;

use App\Tests\Controller\Allocator\AbstractAllocatorControllerTest;

class RandomForOnlyByOneProductTest extends AbstractAllocatorControllerTest
{
    public function testCreate()
    {
        $actualData = $this->getActualData();
        $this->assertArrayHasKey('id', $actualData[0]['responsible_stores'][0]);
        $this->assertEquals($this->expectedData(), $actualData);
    }

    public function expectedData(): array
    {
        return [
            [
                'product_id' => 1,
                'delivery_count' => 1,
                'responsible_stores' => [
                    [
                        'id' => 1,
                    ]
                ],
            ],
            [
                'product_id' => 3,
                'delivery_count' => 1,
                'responsible_stores' => [
                    [
                        'id' => 3,
                    ]
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
                    'product_count' => 1,

                ],
                [
                    'product_id' => 2,
                    'product_count' => 1,

                ],
                [
                    'product_id' => 3,
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
                'store_id' => 1,
                'quantity' => 10,

            ],
            [
                'product_id' => 3,
                'store_id' => 3,
                'quantity' => 10,

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
        ];
    }
}