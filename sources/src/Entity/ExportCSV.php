<?php
namespace App\Entity;

use Doctrine\ORM\Query;


class ExportCSV
{
    protected $object;
    protected $datas;
    protected $stream;

   
    public function __construct($object,$datas, $stream)
    {
        $this->datas = $datas;
        $this->object = $object;
        $this->stream = $stream;
    }
    
    public function generateCSV()
    {

        $fp = fopen($this->stream, 'w');
    

        //
        $properties = $this->getMethods($this->object);
       

        $header = $this->getHeader($properties);
        fputcsv($fp, $header);
        foreach($this->datas as $row)
        {
            $classParent = get_class($row);
           
            $field = [];
           
            foreach($properties as $property=>$method)
            {
               
                if(is_object($row->$method()))
                {
                    $obj = $row->$method();
                    foreach($obj as $row2)
                    {
                        $properties2 = $this->getMethods($row2);
                        foreach($properties2 as $property2=>$method2)
                        {
                            $item = $row2->$method2();
                           
                            if((is_object($item)) && (get_class($item) == $classParent))
                            {
                                echo $property2."  ".$method2." ".get_class($item)."\n";
                                continue;
                            }
                                
                            else
                                $field[] = $row2->$method2();
                        }
                       
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
        
    }

    

    private function getHeader($properties)
    {
        $header = [];
        foreach($properties as $property)
        {
            $header[] = $property;
        }
        return $header;
    }

   

    /**
     * 
     */
    private function getMethods($object)

    {
        $property = [];
        
        $objectvar = get_object_vars($object);
        foreach($objectvar as $key => $value) {
            $property[$key]=$value;
        }
        $class_methods = get_class_methods($object);
        $methods = [];
        foreach ($class_methods as $method_name) {
            if(stristr($method_name,'get'))
            {
                $property = explode('get',$method_name);
                $methods[$property[1]] = $method_name;
            }
        }
        return $methods;
    }
}
