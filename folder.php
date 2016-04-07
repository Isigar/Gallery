<?php
/**
 * Created by PhpStorm.
 * User: relispo
 * Date: 21.3.2016
 * Time: 20:48
 */
/**
 * Co to umí? No jednoduše spravuje to složku :3
*/

namespace App\Model;


use Nette;
use Tester\Dumper;

class folder extends Nette\Object
{
    /**
     * @var int $path Path to folder
    */
    private $path;
    /**
     * @var int $count Count of files in folder
    */
    private $count;
    /**
     * @var array $files Files in folder
    */
    private $files;
    /**
     * @var array $fileStructure
    */
    private $fileStructure;
    /**
     * @var string $folder
    */
    private $folder;
    /**
     * @var array $allowedFiles Allowed ext
    */
    private $allowedFiles;


    public function __construct()
    {

    }

    public function scanFolder()
    {
        if($this->isFolder())
        {
            if($scan = scandir($this->getFolder()))
            {
                $this->setFileStructure($scan);
                return $scan;
            }
            else{
                throw new \Exception("Scan složky nebyl úspěšný! Funkce scandir error!");
            }
        }
        else
        {
            throw new \Exception("Scan složky byl neúspěšný! Složka není složka nebo něco :D");
        }
    }

    public function onlyFiles($once = true)
    {
        if(!empty($this->getFileStructure()))
        {

            if(is_array($this->getFileStructure()))
            {

                foreach($this->getFileStructure() as $file)
                {

                    if($once)
                    {
                        if(!is_dir($file))
                        {
                            if(in_array(explode('.',$file)[1],$this->getAllowedFiles()))
                            {
                                $files = $this->getFiles();
                                $files[] = $file;
                                $this->setFiles($files);
                            }
                            else
                            {
                                continue;
                            }
                        }
                        else
                        {
                            continue;
                        }
                    }
                }
                return $this->getFiles();
            }
            else
            {
                throw new \Exception("Struktura složky není array!");
            }
        }
        else
        {
            throw new \Exception("Pro uspořádání souborů použíj scan funkci prvně blbe!");
        }
    }

    public function onlyFilesEx($ext,$once = true)
    {
        if(!empty($this->getFileStructure()))
        {

            if(is_array($this->getFileStructure()))
            {
                $this->setFiles(null);
                foreach($this->getFileStructure() as $file)
                {

                    if($once)
                    {
                        if(!is_dir($file))
                        {
                            if(in_array(explode('.',$file)[1],$ext))
                            {
                                $files = $this->getFiles();
                                $files[] = $file;
                                $this->setFiles($files);
                            }
                            else
                            {
                                continue;
                            }
                        }
                        else
                        {
                            continue;
                        }
                    }
                }
                return $this->getFiles();
            }
            else
            {
                throw new \Exception("Struktura složky není array!");
            }
        }
        else
        {
            throw new \Exception("Pro uspořádání souborů použíj scan funkci prvně blbe!");
        }
    }

    public function onlyFolders($once = true)
    {
        if(!empty($this->getFileStructure()))
        {

            if(is_array($this->getFileStructure()))
            {

                foreach($this->getFileStructure() as $file)
                {
                    if($file == "." OR $file == "..") continue;
                    if($once)
                    {

                        if(is_dir($this->getFolder()."/".$file))
                        {

                            if(in_array("folder",$this->getAllowedFiles()))
                            {
                                $files = $this->getFiles();
                                $files[] = $file;
                                $this->setFiles($files);
                            }
                            else
                            {
                                continue;
                            }
                        }
                        else
                        {
                            continue;
                        }
                    }
                }
                return $this->getFiles();
            }
            else
            {
                throw new \Exception("Struktura složky není array!");
            }
        }
        else
        {
            throw new \Exception("Pro uspořádání souborů použíj scan funkci prvně blbe!");
        }
    }

    public function isFolder()
    {
        if(!empty($this->getFolder()))
        {
            if(is_dir($this->getFolder()))
            {
                return true;
            }
            else
            {
                throw new \Exception("Nastavená hodnota složky není složka!");
            }
        }
        else{
            throw new \Exception("Galerie nemá nastavenou složku!");
        }
    }


    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param mixed $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * @return mixed
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param mixed $files
     */
    public function setFiles($files)
    {
        $this->files = $files;
    }

    /**
     * @return mixed
     */
    public function getFileStructure()
    {
        return $this->fileStructure;
    }

    /**
     * @param mixed $fileStructure
     */
    public function setFileStructure($fileStructure)
    {
        $this->fileStructure = $fileStructure;
    }

    /**
     * @return mixed
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * @param mixed $folder
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;
    }

    /**
     * @return mixed
     */
    public function getAllowedFiles()
    {
        return $this->allowedFiles;
    }

    /**
     * @param mixed $allowedFiles
     */
    public function setAllowedFiles($allowedFiles)
    {
        $this->allowedFiles = $allowedFiles;
    }

}