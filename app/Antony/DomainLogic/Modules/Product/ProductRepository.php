<?php namespace app\Antony\DomainLogic\Modules\Product;

use app\Antony\DomainLogic\Modules\DAL\EloquentRepository;

class ProductRepository extends EloquentRepository
{
    /**
     * The product sku
     *
     * @var string
     */
    protected $skuString = 'PCW';

    /**
     * @param $key
     * @param $operator
     * @param $value
     *
     * @param array $columns
     * @return mixed
     */
    public function where($key, $operator, $value, $columns = ['*'])
    {
        return $this->model->where($key, $operator, $value);
    }

    /**
     * Add a product to stock
     *
     * @param $data
     *
     * @return static
     */
    public function add($data)
    {
        // create product SKU
        $this->model->creating(function ($product) use ($data) {

            $product->sku = $this->generateProductSKU();

            $product->category_id = array_get($data, 'category_id');
            $product->subcategory_id = array_get($data, 'subcategory_id');
            $product->brand_id = array_get($data, 'brand_id');
        });

        return parent::add($data);
    }

    /**
     * Generate a sample product SKU
     *
     * @return string
     */
    public function generateProductSKU()
    {
        return $this->skuString . int_random();
    }

    /**
     * @param $data
     * @param $id
     *
     * @return bool|int
     */
    public function update($data, $id)
    {
        return parent::update($data, $id);
    }

    /**
     * Specify the Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return 'App\Models\Product';
    }
}