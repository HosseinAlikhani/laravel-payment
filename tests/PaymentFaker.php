<?php
namespace D3cr33\Payment\Test;

final class PaymentFaker
{
    /**
     * generate fake unique id
     * @return int
     */
    public function uniqueId(): int
    {
        return fake()->numberBetween(9999, 999999);
    }

    /**
     * generate fake port
     * @return string
     */
    public function port(): STRING
    {
        return 'ZARINPAL';
    }

    /**
     * generate fake model type
     * @return string
     */
    public function modelType(): string
    {
        return fake()->lexify("????????") . "\\" . fake()->lexify("????????") . "\\" . fake()->lexify("????????");
    }

    /**
     * generate fake amount
     * @return int
     */
    public function amount(): int
    {
        return fake()->numerify("####000");
    }

    /**
     * generate fake description
     * @return string
     */
    public function description(): string
    {
        return fake()->text(100);
    }

    /**
     * generate fake authority
     * @return string
     */
    public function authority(): string
    {
        return fake()->numerify("00000000000000000000000000000#######");
    }
}