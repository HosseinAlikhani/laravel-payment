<?php
namespace D3cr33\Payment\Test;

final class PaymentFaker
{
    /**
     * generate fake unique id
     */
    public function uniqueId()
    {
        return fake()->numberBetween(9999, 999999);
    }
}