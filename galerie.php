<?php

namespace App\Model;

use Nette;
use Tracy\Dumper;

class galerie extends Nette\Object
{
    private $images;
    private $galeryName = "Galerie";
    private $galeryPath = "/";
    private $wwwPath;

    public function render($wwwPath,$folder=false)
    {
        $this->setWwwPath($wwwPath);

        if(is_array($this->getImages()))
        {
            $html = "";
            foreach($this->getImages() as $image)
            {
                if($folder)
                    $html .= $this->toHtmlDir($wwwPath."/".$image);
                else
                    $html .= $this->toHtml($wwwPath."/".$image);
            }
            return $html;
        }
        else
        {
            return $this->toHtml($this->getImages());
        }
    }

    private function toHtml($image)
    {
        $var = '<a href="'.$image.'" data-lightbox="galery" data-title="'.$this->getGaleryName().'"><img src="'.$image.'" class="galery-image span3" alt="'.$this->getGaleryName().'" /></a>';
        return $var;
    }

    private function toHtmlDir($image)
    {
        $editFold = str_replace("/stoline.cz/www","",$image);
        $imageFold = explode('/',$image);

        $folder = new folder();
        $folder->setFolder(WWW_DIR.$editFold);
        $folder->setAllowedFiles(array("png","jpg","jpeg"));
        $folder->scanFolder();
        $src = $folder->onlyFiles()[0];
        $name = file_get_contents(WWW_DIR.$editFold."/name.txt");

        $var = '<a href="'.$imageFold[sizeof($imageFold)-2].'/'.$imageFold[sizeof($imageFold)-1].'">
                    <div class="folder span4">
                        <img src="'.$image."/".$src.'" class="galery-image" alt="'.$name.'" />
                        <div class="folder-text">'.$name.'</div>
                    </div>
                </a>';
        return $var;
    }

    /**
     * @return mixed
     */
    public function getGaleryPath()
    {
        return $this->galeryPath;
    }

    /**
     * @param mixed $galeryPath
     */
    public function setGaleryPath($galeryPath)
    {
        $this->galeryPath = $galeryPath;
    }

    /**
     * @return mixed
     */
    public function getGaleryName()
    {
        return $this->galeryName;
    }

    /**
     * @param mixed $galeryName
     */
    public function setGaleryName($galeryName)
    {
        $this->galeryName = $galeryName;
    }

    /**
     * @return mixed
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param mixed $images
     */
    public function setImages($images)
    {
        $this->images = $images;
    }

    /**
     * @return mixed
     */
    public function getWwwPath()
    {
        return $this->wwwPath;
    }

    /**
     * @param mixed $wwwPath
     */
    public function setWwwPath($wwwPath)
    {
        $this->wwwPath = $wwwPath;
    }


}