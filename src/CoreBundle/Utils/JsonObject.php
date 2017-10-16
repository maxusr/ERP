<?php
namespace CoreBundle\Utils;

abstract class JsonObject implements \JsonSerializable {
    /*
    public function toArray($container) {
        $serializer = $container->get('jms_serializer');
        return json_decode($serializer->serialize($this, 'json'));
    }

    public function populate(array $array, $container) {
        return $this->toObject($array, $container);
    }

    public function toObject($array, $container) {
        $json = json_encode($array);
        $serializer = $container->get('jms_serializer');
        return $serializer->deserialize($json, get_class($this), 'json');
    }
    */
    
    public abstract function getObjectVars();

    public function jsonSerialize() {
        return $this->toArray();
    }
   
    private function processArray($array, $recursive = false) {
        if(!$recursive){
            foreach($array as $key => $value) {
                if (is_object($value)) {
                    if($value instanceof \Doctrine\Common\Collections\Collection || $value instanceof \Doctrine\ORM\PersistentCollection){
                        //$array[$key] = $this->processArray($value->toArray());
                    }else if($value instanceof JsonObject){
                        $array[$key] = $value->toArray(true);
                    }else{
                        $array[$key] = get_object_vars($value);
                    }
                }
                if (is_array($value)) {
                    $array[$key] = $this->processArray($value);
                }
            }
        }
        // If the property isn't an object or array, leave it untouched
        return $array;
    }

    public function toArray($recursive = false) {
        $vars = $this->getObjectVars();
        foreach ($vars as $key => $value) {
            if(substr($key, 0, 1) != '_'){
                if(!$recursive){
                $var[$key] = $value;
                }else{
                    if(!is_object($value)){
                        $var[$key] = $value;
                    }else{
                        $var[$key] = null;
                    }
                }
            }
        }
        return $this->processArray($var, $recursive);
    }

    public function __toString() {
        return json_encode($this->toArray());
    }
    /*
    public function populate(array $array, $em) {
        $attrsValues = get_object_vars($this);
        $attrs = array_keys($attrsValues);

        foreach ($array as $key => $value) {
            if(in_array($key, $attrs) && !empty($value)){
                $setMethod = 'set'.ucfirst($key);
                $addMethods = 'add'.ucfirst(substr($key, 0, -1));
                $addMethodies = 'add'.ucfirst(substr($key, 0, -3)).'y';
                if(method_exists($this, $addMethodies)){
                    $this->populateAttrib($value, $addMethodies, $em, true);
                }elseif(method_exists($this, $addMethods)){
                    $this->populateAttrib($value, $addMethods, $em, true);
                }else{
                    if(method_exists($this, $setMethod)){
                        $this->populateAttrib($value, $setMethod, $em);
                    }
                }
            }
        }
    }
    
    protected function populateAttrib($value, $method, $em, $isAdd = false) {

        $r = new \ReflectionMethod($this, $method);
        $params = $r->getParameters();
        foreach ($params as $k => $param) {
            $objName = $param->getClass();
            $typeName = $this->getTypeParam($param);
            if(is_null($objName) || in_array($typeName,array('int','string','null','float','double','bool','boolean','long'))){
                if($method == 'setId'){
                    if(empty($this->getId())){
                        $this->setIdentifier($value);
                    }
                }else{
                    $this->$method($value);
                }
            }else{
                $objShortName = $objName->getShortName();
                $objName = $objName->getName();
                $obj = new $objName;
                if($obj instanceof JsonObject){
                    if(is_array($value)){
                        if($isAdd){
                            foreach ($value as $j => $v) {
                                if(array_key_exists('id', $v) && !empty($v['id'])){
                                    //throw new \Exception("Exception test for $objShortName with id ".$value['id'], 1);
                                    
                                    $obj = $em->getRepository("RestBundle:".$objShortName)->findOneById($v['id']);
                                    $obj->populate($v, $em);
                                }else{
                                    $obj->populate($v, $em);
                                }
                                $this->$method($obj);
                            }
                        }else{
                            if(array_key_exists('id', $value) && !empty($value['id'])){
                                //throw new \Exception("Exception test for $objShortName with id ".$value['id'], 1);
                                
                                $obj = $em->getRepository("RestBundle:".$objShortName)->findOneById($value['id']);
                                if(!is_null($obj))
                                    $obj->populate($value, $em);
                            }else{
                                $obj->populate($value, $em);
                            }
                            $this->$method($obj);
                        }
                    }
                }
            }
        }
    }

    protected function getTypeParam($refParam) {

        $export = \ReflectionParameter::export(
        array(
            $refParam->getDeclaringClass()->name, 
            $refParam->getDeclaringFunction()->name
        ), 
        $refParam->name, 
        true
        );

        $type = preg_replace('/.*?(\w+)\s+\$'.$refParam->name.'.*-/', '\\1', $export);
        return $type;
    }
    */
    
}