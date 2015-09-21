<?php

namespace Ballet\PostBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\MimeType;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * User
 */
class Image
{
    /*
     * @var integer
     */
    public $id;
    /*
     * @var string
     */
    public $name;
    /*
     * @var string
     */
    public $path;

    /**
     * @Assert\NotBlank()
     * @Assert\Image(
     *     maxSize= "3072k",
     *     minWidth = 200,
     *     maxWidth = 4000,
     *     minHeight = 200,
     *     maxHeight = 4000
     * )
     */
    private $file;

    /**
     * @var integer
     */
    private $picId;

    /**
     * @var integer
     */
    private $userId;

    /**
     * @var integer
     */
    private $description;

    /**
     * @var integer
     */
    private $uploadDate;

    /**
     * @var integer
     */
    private $avrAge;

    /**
     * @var integer
     */
    private $voters;

    public function __construct()
    {
        $this->uploadDate = new \DateTime('now');;

    }


    public function preUpload()
    {
        if (null !== $this->file) {
            $filename = sha1(uniqid(mt_rand(), true));
            $this->path = $filename.'.'.$this->file->guessExtension();
        }
    }

    /**
     * Get picId
     *
     * @return integer 
     */
    public function getPicId()
    {
        return $this->picId;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return Image
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Image
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Image
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getTmpDir().'/'.$this->path;
    }

    public function getThumbnailPath($thumbnailSize) {
        return 'media/cache/' . $thumbnailSize . '/images/' . $this->path;
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getTmpDir();
    }

    protected function getTmpDir()
    {
        return 'images';
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }


    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }

    public function removeThumbnail($thumbnailSize)
    {
        if ($file = $this->getThumbnailPath($thumbnailSize)) {
            unlink($file);
        }
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @return string
     */
    public function setDescription($description)
    {
        return $this->description = $description;
    }

    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }
        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->path
        );

        $this->file = null;
    }

    /**
     * Set uploaddate
     *
     * @param \DateTime $uploaddate
     * @return Image
     */
    public function setUploadDate($uploadDate)
    {
        $this->uploadDate = $uploadDate;
        return $this;
    }

    /**
     * Get uploaddate
     *
     * @return \DateTime 
     */
    public function getUploadDate()
    {
        return $this->uploadDate;
    }

    /**
     * Get avrAge
     *
     * @return \DateTime
     */
    public function getAvrAge()
    {
        return $this->avrAge;
    }

    public function setAvrAge($avrAge)
    {
        $this->avrAge = $avrAge;
    }

    public function getVoters()
    {
        return $this->voters;
    }

    public function setVoters()
    {
        $this->voters = $this->voters + 1;
    }
}
