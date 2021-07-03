<?php
namespace App\Entity;

/**
 * Classe générique permettant d'exporter les données en base d'une table définis par une entity.
 * Toutes les proprietés public sont exportées ainsi que que les propriété des relations filles.
 * 
 */
use Doctrine\ORM\Query;
use phpDocumentor\Reflection\Types\Boolean;

class ExportCSV
{
    protected $object;    ///** Entity Parent */
    protected $datas;     ///** Flux de donnée */
    protected $stream;    ///** Fichier a générer */
    protected $cpt;       ///** On limite le nombre de relation à 2 pour raisons de lisibilité de l'export */

   
    public function __construct($object,$datas, $stream)
    {
        $this->datas = $datas;
        $this->object = $object;
        $this->stream = $stream;
        $this->cpt = 2;
    }
    
    /**
     * Génération du csv de l'entity $object
     *
     * @return void
     */
    public function generateCSV()
    {
        try
        {
            $fp = fopen($this->stream, 'w');
            $methods = $this->getMethods($this->object);
            $header = [];
            foreach($this->datas as $row)
            {
                if(empty($header))
                {
                    $header = $this->getHeader($row,$methods);
                    fputcsv($fp,$header);
                }
                $field = [];
                foreach($methods as $property=>$method)
                {
                    if(is_object($row->$method()))
                    {
                        if(!$this->isCallable($row->$method()))
                            continue;
                        $this->cpt = 0;
                        foreach($row->$method() as $row2)
                        {
                            if($this->cpt > 1)
                                break;
                            $methodsChild = $this->getMethods($row2);
                            foreach($methodsChild as $propertyChild=>$methodChild)
                            {
                                if($this->isCallable($row2->$methodChild(), $row))
                                {
                                    $field[] = $row2->$methodChild();
                                }
                            }
                            $this->cpt++;
                        }
                    }
                    else
                    {
                        $field[] = $row->$method();
                    }
                }
                fputcsv($fp, $field);
            }
            fclose($fp);
            return TRUE;

        }
        catch(\Throwable $e)
        {
            return ['status' => 'Error!','message' => $e->getMessage()];
        }
    }

    /**
     * Verifie si la methode Child ne retourne pas un objet non callable
     *
     * @param [type] $child
     * @param [type] $parent
     * @return Bool
     */
    private function isCallable($child, $parent = null): Bool
    {
        $objectParent = null;
        if($parent)
            $objectParent = get_class($parent);
        
        if(is_object($child))
        {
            $class = get_class($child);
            if ((strpos($class, "Proxies") !== FALSE) || (strpos($class, "Doctrine\ORM\PersistentCollectionRetenu") !== FALSE))
                return FALSE;
            if($objectParent != null)
            {
                if (strpos($class, $objectParent) !== FALSE)
                    return FALSE;
            }
        }
        return TRUE;
    }

    /**
     * Reconstitution des entêtes de colonnes à partir des proprieté et méthodes de la classe
     *
     * @param [type] $row
     * @param [type] $methods
     * @return array
     */
    private function getHeader($row,$methods): array
    {
        $header = [];
        foreach($methods as $property=>$method)
        {
            if(is_object($row->$method()))
            {
                if(is_array($row->$method()))
                    $rowChild = $row->$method()[0];
                else
                    $rowChild = $row->$method();
                for($i=0; $i<$this->cpt; $i++) /** profondeur 2 */
                {
                    foreach($rowChild as $propertyChild=>$methodChild)
                    {
                            $header[] = $property.'_'.$propertyChild.'_'.$i;
                    }
                }
            }
            else
                $header[] = $property;
        }
        return $header;
    }

   
    /**
     * Récupéres les propriétés et les getter de la classe $object
     *
     * @param [type] $object
     * @return array
     */
    private function getMethods($object): array
    {
        $methods = [];
        $methodList = get_class_methods($object);
        foreach ($methodList as $method_name) {
            if(stristr($method_name,'get'))
             $methods[substr($method_name,3)] = $method_name;
        }
        return $methods;
    }
}
