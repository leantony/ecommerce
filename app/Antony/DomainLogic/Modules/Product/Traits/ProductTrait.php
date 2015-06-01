<?php namespace app\Antony\DomainLogic\Modules\Product\Traits;

use Carbon\Carbon;
use Illuminate\Support\Collection;

trait ProductTrait
{

    /**
     * Returns the name of a product
     *
     * @return string
     */
    public function name()
    {
        return beautify($this->name);
    }

    /**
     * Determines if a product is new
     *
     * @return bool
     */
    public function isNew()
    {
        $byWhen = Carbon::now()->subDays(config('site.products.new.age', 14));

        return $this->created_at >= $byWhen;
    }

    /**
     * Checks if a product is taxable
     *
     * @return bool
     */
    public function isTaxable()
    {
        return $this->taxable;
    }

    /**
     * Checks is a product needs to display a low warning in stock message to the client
     *
     * @return bool
     */
    public function needsStockWarning()
    {
        return $this->quantity <= config('site.products.quantity.low_threshold', 2) & !$this->hasRanOutOfStock();
    }

    /**
     * determine if a product has ran out of stock
     *
     * @return bool
     */
    public function hasRanOutOfStock()
    {
        return empty($this->quantity);
    }

    /**
     * Checks if a product needs a text input field for quantity
     *
     * @return bool
     */
    public function needsTextInputForQuantity()
    {
        return $this->quantity <= config('site.products.quantity.max_selectable', 10);
    }

    /**
     * Displays products related to the current product
     *
     * @return Collection
     */
    public function getRelated()
    {

        $currentProduct = $this;

        $data = $this->subcategory()->with('products.reviews')->whereId($this->subcategory->id)->get();

        // if a product related to the current product's subcategory wasn't found, we try finding
        // those related to it's category
        if ($data->count() === 0) {

            $data = $this->category()->with('products.reviews')->whereId($this->category->id)->get();
        }

        $output = new Collection();

        // streamline the collection to only include the product objects
        foreach ($data as $subcategory) {

            foreach ($subcategory->products as $product) {

                $output->push($product);
            }

        }

        // prevent the current product from being displayed in this list, and also limit items returned to 10
        $output = $output->filter(function ($item) use ($currentProduct) {

            return $item->id !== $currentProduct->id;

        })->take(10);

        return $output->sortBy(function ($p) {
            return $p->name;
        });
    }
}
