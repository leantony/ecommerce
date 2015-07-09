<?php namespace app\Antony\DomainLogic\Modules\Images;

use app\Antony\DomainLogic\Contracts\Imaging\ImagingInterface;
use Illuminate\Database\Eloquent\Model;
use Image;

class ImageProcessor implements ImagingInterface
{

    /**
     * The root path of the image storage directory
     *
     * @var string
     */
    public $rootPath = '/assets/';

    /**
     * The original path of the image
     *
     * @var string
     */
    public $originalPath;

    /**
     * The original name of the image
     *
     * @var string
     */
    public $originalName;

    /**
     * Eloquent Model that the image property is related to
     *
     * @var Model
     */
    public $model;

    /**
     * The image property of the model
     *
     * @var string
     */
    public $property;

    /**
     * The quality of the image to be saved
     *
     * @var int
     */
    public $imgQuality = 80;

    /**
     * The storage location of the generated image
     *
     * @var string
     */
    public $storageLocation;

    /**
     * A unique generated name, for the image
     *
     * @var string
     */
    public $uniqueName;

    /**
     * Specifies if the image should be resized
     *
     * @var boolean
     */
    public $resize = false;

    /**
     * Specifies if the image should be resized, using the best fit method
     *
     * @var boolean
     */
    public $fit = false;

    /**
     * Intermediate result after processing an image
     *
     * @var mixed
     */
    public $data;

    /**
     * Dimensions which will be used to resize an image
     *
     * @var array
     */
    public $resizeDimensions = [];

    /**
     * Initialize key variables, and attempt to link up all the processing functions
     *
     * @param Model $model
     * @param $attribute
     *
     * @return $this
     */
    public function init(Model $model, $attribute)
    {
        $this->model = $model;

        $this->property = $attribute;

        $this->data = $this->getOriginalImagePath($this->property)
            ->getOriginalImageName($this->property)
            ->getUniqueImageName()->createImage();

        return $this;
    }

    /**
     * Creates the image, and saves it to the filesystem
     * In this case, we are using the intervention image library
     *
     * @return mixed
     */
    public function createImage()
    {
        if ($this->resize) {

            // get the resize dimensions
            $height = (int)array_get($this->resizeDimensions, 'new_height', 320);

            $width = (int)array_get($this->resizeDimensions, 'new_width', 240);

            if ($this->fit) {
                return Image::make($this->originalPath)->fit($width, $height)
                    ->save(base_path() . $this->storageLocation . '/' . $this->uniqueName, $this->imgQuality);
            } else {
                return Image::make($this->originalPath)->resize($width, $height)
                    ->save(base_path() . $this->storageLocation . '/' . $this->uniqueName, $this->imgQuality);
            }

        } else {

            return Image::make($this->originalPath)
                ->save(base_path() . $this->storageLocation . '/' . $this->uniqueName, $this->imgQuality);
        }
    }

    /**
     * Gets the unique name of an image
     *
     * @return $this
     */
    public function getUniqueImageName()
    {
        // timestamp + slug
        $name = time() . '-' . str_slug($this->originalName);

        $name = str_replace($this->getExtension($this->property), '', $name);

        $this->uniqueName = $name . '.' . $this->getExtension($this->property);

        return $this;
    }

    /**
     * Gets the extension of the uploaded image
     *
     * @param $property
     *
     * @return mixed
     */
    public function getExtension($property)
    {
        return $this->model->$property->getClientOriginalExtension();
    }

    /**
     * Gets the original name of the image
     *
     * @param $property
     *
     * @return $this
     */
    public function getOriginalImageName($property)
    {
        $this->originalName = $this->model->$property->getClientOriginalName();

        return $this;
    }

    /**
     * Gets the original path of the image uploaded
     *
     * @param $property
     *
     * @return $this
     */
    public function getOriginalImagePath($property)
    {
        $this->originalPath = $this->model->$property->getRealPath();

        return $this;
    }

    /**
     * Gets the processed image
     *
     * @return null|string
     */
    public function getImage()
    {
        if (empty($this->data)) {
            // failure in processing the image. nothing much we can do
            return null;
        } else {
            $path = $this->data->basePath();

            // get path to image
            return $this->processImagePath($path);
        }
    }

    /**
     * processes the images base bath, to reflect our images storage root directory
     *
     * @param $path
     *
     * @return string
     */
    public function processImagePath($path)
    {
        $pos = strpos($path, $this->rootPath);
        if ($pos !== false) {

            return substr($path, $pos);
        }

        return $path;
    }

    /**
     * Attempts to scale down an image, by finding the best fit
     *
     * @param $image
     * @param $times
     *
     * @return null|string
     */
    public function reduceImage($image, $times)
    {
        // first we check if the image exists, so that we work on it
        $result = file_exists_on_server($image);

        if ($result) {
            // create image from data provided. in this case, the data provided is the path to the image
            $oldImage = Image::make(public_path() . $image);
            // get dimensions
            $width = ceil($oldImage->getWidth() / $times);

            $height = ceil($oldImage->getHeight() / $times);

            // resize the image
            if ($this->fit) {
                $oldImage->fit($width, $height);
            } else {
                $oldImage->resize($width, $height);
            }

            // image name
            $name = str_replace($oldImage->extension, '', $this->uniqueName . '-small' . '.' . $oldImage->extension) . $oldImage->extension;

            // path variable
            $path = base_path() . $this->storageLocation . '/' . $name;

            // save new image in filesystem
            $newImage = $oldImage->save($path);
            if (empty($newImage)) {
                // failure in processing the image. nothing much we can do
                return null;
            }

            // return the path to the reduced image
            return $this->processImagePath($newImage->basePath());

        } else {

            return null;
        }

    }
}