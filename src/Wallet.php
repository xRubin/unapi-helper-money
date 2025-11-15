<?php

namespace unapi\helper\money;

class Wallet
{
    /** @var MoneyAmount[] */
    private $money = [];

    /**
     * @param MoneyAmount[] $money
     */
    public function __construct(array $money = [])
    {
        $this->money = $money;
    }

    /**
     * @return MoneyAmount[]
     */
    public function getMoney(): array
    {
        return array_values(
            array_filter(
                $this->money,
                function (MoneyAmount $money) {
                    return !$money->isZero();
                }
            )
        );
    }

    /**
     * @param Currency $currency
     * @return MoneyAmount|null
     */
    public function getMoneyByCurrency(Currency $currency): ?MoneyAmount
    {
        foreach ($this->money as $money) {
            if ($money->getCurrency()->value === $currency->value)
                return $money;
        }

        return null;
    }

    /**
     * @param MoneyAmount $money
     * @return Wallet
     */
    public function addMoney(MoneyAmount $money): Wallet
    {
        $data = $this->money;
        foreach ($data as $key => $value) {
            if ($value->getCurrency()->value === $money->getCurrency()->value) {
                $data[$key] = $value->add($money);
                return new Wallet($data);
            }
        }
        $data[] = $money;
        return new Wallet($data);
    }

    /**
     * @param MoneyAmount $money
     * @return Wallet
     */
    public function subMoney(MoneyAmount $money): Wallet
    {
        $data = $this->money;
        foreach ($data as $key => $value) {
            if ($value->getCurrency()->value === $money->getCurrency()->value) {
                $data[$key] = $value->sub($money);
                return new Wallet($data);
            }
        }
        $data[] = new MoneyAmount(-$money->getAmount(), $money->getCurrency());
        return new Wallet($data);
    }

    /**
     * @return bool
     */
    public function hasNegativeAmount(): bool
    {
        foreach ($this->money as $money) {
            if ($money->isNegative())
                return true;
        }

        return false;
    }
}