<?php namespace App\ModelObservers;

use App\Antony\DomainLogic\Contracts\Imaging\ImagingInterface;
use App\Models\Product;

class ProductObserver
{
    /**
     * The image processor implementation
     *
     * @var ImagingInterface
     */
    protected $image;

    /**
     * @param ImagingInterface $imageProcessor
     */
    public function __construct(ImagingInterface $imageProcessor)
    {
        $this->image = $imageProcessor;

        $this->image->storageLocation = config('site.products.images.storage');

        $this->image->resizeDimensions = config('site.products.images.dimensions');

        $this->image->resize = false;
    }

    /**
     * @param Product $model
     *
     * @return bool
     */
    public function saving(Product $model)
    {
        // if there is a new image, then do sth. otherwise leave the original one
        if ($model->isDirty('image')) {

            // check if old product images exist on the filesystem and delete them
            $deleteResult = $this->deleteProductImages($model);

            $path = $this->image->init($model, 'image')->getImage();

            if (empty($path)) {
                return false;
            }

            $model->image_large = $path;

            // create the small image
            $model->image = $this->image->reduceImage($model->image_large, config('site.products.images.reduce_ratio'));

            if (is_null($model->image_large or is_null($model->image))) {
                // error. just bail out
                return false;
            }

            return true;
        }

        return true;
    }

    /**
     * @param Product $model
     *
     * @return bool
     */
    public function deleting(Product $model)
    {
        return $this->deleteProductImages($model);
    }

    /**
     * @param Product $model
     *
     * @return bool|null
     */
    private function deleteProductImages(Product $model)
    {
        $images = [$model->image, $model->image_large];

        $result = null;

        foreach ($images as $image) {

            if (file_exists_on_server($image)) {

                $result = delete_file($image);
            }
        }

        return $result;
    }

}