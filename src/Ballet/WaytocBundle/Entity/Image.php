<?php

namespace Ballet\WaytocBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
    /*
     * @var string
     */
    private $file;

    /**
     * @var integer
     */
    private $picid;

    /**
     * @var integer
     */
    private $userid;

    /**
     * @var integer
     */
    private $description;

    /**
     * @var integer
     */
    private $uploaddate;


    public function __construct()
    {
//        $this->userid = 96;
        $this->uploaddate = new \DateTime('now');;
    }
    /**
     * Get picid
     *
     * @return integer 
     */
    public function getPicid()
    {
        return $this->picid;
    }

    /**
     * Set userid
     *
     * @param integer $userid
     * @return Image
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;

        return $this;
    }

    /**
     * Get userid
     *
     * @return integer 
     */
    public function getUserid()
    {
        return $this->userid;
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
            : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/images';
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

    public function preUpload()
    {
        if (null !== $this->file) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->path = $filename.'.'.$this->file->guessExtension();
        }
    }

    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
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
        $this->preUpload();
        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getFile()->getClientOriginalName()
        );
        $this->path = $this->getFile()->getClientOriginalName();
        $this->file = null;
    }

    /**
     * Set uploaddate
     *
     * @param \DateTime $uploaddate
     * @return Image
     */
    public function setUploaddate($uploaddate)
    {
        $this->uploaddate = $uploaddate;

        return $this;
    }

    /**
     * Get uploaddate
     *
     * @return \DateTime 
     */
    public function getUploaddate()
    {
        return $this->uploaddate;
    }
}
