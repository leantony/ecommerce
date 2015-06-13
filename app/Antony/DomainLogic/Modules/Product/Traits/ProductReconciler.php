<?php namespace app\Antony\DomainLogic\Modules\Product\Traits;

use app\Antony\DomainLogic\Modules\ShoppingCart\Formatters\MoneyFormatter;
use app\Antony\DomainLogic\Modules\ShoppingCart\Tax\KenyanTaxRate;
use App\Models\Product;
use Money\Currency;
use Money\Money;

trait ProductReconciler
{
    /**
     * Default product quantity, if not set
     *
     * @var int
     */
    protected $qt = 1;

    /**
     * The product instance
     *
     * @var Product
     */
    private $product = null;

    /**
     * Set the product quantity
     *
     * @param $value
     *
     * @return $this
     */
    public function quantity($value)
    {
        $this->qt = (int)$value;

        return $this;
    }

    /**
     * Return the total of the Product
     *
     * @return Money
     */
    public function total()
    {
        $tax = $this->tax();
        $subtotal = $this->subtotal();
        $total = $subtotal->add($tax);
        return $total;
    }

    /**
     * Return the tax of the Product
     *
     * @return Money
     */
    public function tax()
    {
        $product = $this->getProduct();

        $rate = new KenyanTaxRate();

        $tax = $this->money();

        if (!$product->taxable || $product->free) {
            return $tax;
        }

        $value = $this->value();
        $discount = $this->discount();

        $value = $value->subtract($discount);
        $tax = $value->multiply($rate->float());

        return $tax;
    }

    /**
     * Gets the product instance
     *
     * @return $this|Product
     *
     */
    public function getProduct()
    {
        if (is_null($this->product)) {
            return $this;
        }
        return $this->product;
    }

    /**
     * Sets the product instance
     *
     * @param Product $product
     *
     * @return $this
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Create an initial zero money value
     *
     * @return Money
     */
    private function money()
    {
        $product = $this->getProduct();

        return new Money(0, $product->price->getCurrency());
    }

    /**
     * Return the value of the Product
     *
     * @return Money
     */
    public function value()
    {
        $product = $this->getProduct();

        return $product->price->multiply($this->qt);
    }

    /**
     * Return the discount of the Product
     *
     * @return Money
     */
    public function discount()
    {
        $product = $this->getProduct();

        $discount = $this->money($product);
        if ($product->discount) {
            $discount = $product->discount->product($product);
            $discount = $discount->multiply($this->qt);
        }
        return $discount;
    }

    /**
     * Return the subtotal of the Product
     *
     * @return Money
     */
    public function subtotal()
    {
        $product = $this->getProduct();

        $subtotal = $this->money();
        if (!$product->free) {
            $value = $this->value();
            $discount = $this->discount();
            $subtotal = $subtotal->add($value)->subtract($discount);
        }
        $delivery = $this->delivery();
        $subtotal = $subtotal->add($delivery);
        return $subtotal;
    }

    /**
     * Return the delivery charge of the Product
     *
     * @return Money
     */
    public function delivery()
    {
        $product = $this->getProduct();

        $delivery = $product->shipping->multiply($this->qt);
        return $delivery;
    }

    /**
     *
     * @return Money
     */
    public function valuePlusTax()
    {
        return $this->value()->add($this->tax());
    }

    /**
     * Formats a money object to price + value. eg Money A becomes KSH 10000
     *
     * @param $money
     *
     * @return mixed
     */
    public function formatMoneyValue($money)
    {
        if (!$money instanceof Money) {

            $money = new Money((int)$money, new Currency($this->defaultCurrency));
        }
        $formatter = new MoneyFormatter();

        return $formatter->format($money);
    }
}