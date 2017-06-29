<?php

namespace tinhead\serialization;


class DtoSerializer implements ISerializer
{

    const BOOL_TYPE = "boolean";
    const INT_TYPE = "integer";
    const DOUBLE_TYPE = "double";
    const STRING_TYPE = "string";
    const ARRAY_TYPE = "array";
    const OBJECT_TYPE = "object";


    /**
     * Returns a JSON string representation of the given object.
     *
     * @param ISerializable $dto
     * @return string
     */
    public function serialize(ISerializable $dto):string {
        $dtoArray = $this->serializeToArray($dto);
        $result = json_encode($dtoArray);
        return $result;
    }

    /**
     * Converts the given object into a associative array.
     * All public attributes of type boolean, integer, double, string and array of the object will be taken
     * into the array. Attributes of type ISerializable will be converted into an sub-array (recursion).
     * Attributes with value null will be also be taken into the array.
     *
     * @param ISerializable $dto
     * @return array
     */
    public function serializeToArray(ISerializable $dto):array {

        $result = array();

        if ($dto != null) {
            foreach($dto as $key => $value) {

                    $valueType = gettype($value);
                    if (   $value == null
                        || $valueType == self::BOOL_TYPE
                        || $valueType == self::INT_TYPE
                        || $valueType == self::DOUBLE_TYPE
                        || $valueType == self::STRING_TYPE
                        || $valueType == self::ARRAY_TYPE )
                    {

                        // Atomic values are just stored in the result array
                        $result[$key] = $value;

                    } else if ($valueType == self::OBJECT_TYPE) {

                        // Child objects will also be serialized, if they implement the ISerializable interface.
                        if (is_subclass_of($value, "\\tinhead\\serialization\\ISerializable")) {
                            $result[$key] = $this->serializeToArray($value);
                        }
                    }



            }
        }

        return $result;
    }
}