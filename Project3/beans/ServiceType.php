<?php
/*SERVICE_NAME
 DURATION*/
class ServiceType implements JsonSerializable
{
    private  $id;
    private  $serviceName;
    private  $duration;

    function __construct($id,$serviceName,$duration)
    {
        $this->id = $id;
        $this->serviceName = $serviceName;
        $this->duration=$duration;
    }

    public static function createObjectFromJson( $json)
    {
        if(!isset($json)) throw new Exception("null Exception!");
        $object = $json;
        return new self($object['id'],$object['serviceName'], $object['duration']);
    }

    public static function createObjectsFromJsonArray( $jsonArray )
    {
        $objArray = [];
//        $array = json_decode( $jsonArray );
        foreach ($jsonArray as $object)
            $objArray[] = new self($object['id'],$object['serviceName'], $object['duration']);


        return $objArray;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'serviceName' => $this->serviceName,
            'duration' => $this->duration
        ];
    }

    function equals(ServiceType $service)
    {

        $isEquals = $this->serviceName === $service->serviceName;
        if(!$isEquals)return false;
        $isEquals = $this->duration === $service->duration;
        if(!$isEquals)return false;
        else return true;
    }



    function getId(){return $this->id;}
    function setId($id){$this->id = $id;}

    function getServiceName(){return $this->serviceName;}
    function setServiceName($serviceName){$this->serviceName = $serviceName;}

    function getDuration(){return $this->duration;}
    function setDuration($duration){$this->duration=$duration;}




}

?>







