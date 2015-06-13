<?php namespace App\ModelObservers;

use App\Antony\DomainLogic\Contracts\Imaging\ImagingInterface;
use App\Models\User;

class UserObserver
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

        $this->image->storageLocation = config('site.users.images.storage');

    }

    /**
     * @param User $model
     *
     * @return bool
     */
    public function saving(User $model)
    {
        // process the image, only if it is there / modified
        if ($model->isDirty('avatar')) {

            // delete old avatar
            $deleteResult = $this->deleteOldImages($model);

            // check if the avatar is a url path. we would skip it
            if (is_string($model->avatar)) {

                return true;

            }
            $path = $this->image->init($model, 'avatar')->getImage();

            if (empty($path)) {
                return false;
            }

            $model->avatar = $path;

            return true;
        }
        return true;

    }

    /**
     * @param User $model
     *
     * @return bool
     */
    public function deleting(User $model)
    {
        // find the image on disk and delete it
        $current_image = $model->avatar;

        if (is_string($current_image)) {
            return true;
        }
        return file_exists_on_server($current_image) ? delete_file($current_image) : true;
    }

    /**
     * @param User $model
     *
     * @return bool|null
     */
    private function deleteOldImages(User $model)
    {
        $image = $model->avatar;

        if (is_string($image)) {
            return true;
        }

        return file_exists_on_server($image) ? delete_file($image) : true;
    }
}