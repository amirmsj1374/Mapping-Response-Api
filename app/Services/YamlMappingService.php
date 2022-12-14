<?php

namespace App\Services;

use Yaml;

class YamlMappingService
{
    /**
     * Return data according to the desired format by using a yaml file (mapping)
     */
    public function getData(array $originalArray)
    {
        $keys = file_get_contents(database_path('mapping.yml'));
        $yamlArray = Yaml::parse($keys);
        $fields = $this->getFields($yamlArray);
        $deletedFields = $this->getDeletedFields($yamlArray);
        return $this->recursiveChangeKey($originalArray, $fields, $deletedFields);
    }

    /**
     * This method is for changing array keys according to what we need and removing some keys
     */
    private function recursiveChangeKey(array $originalArray, array $Changedkeys, array $deletedFields) :array
    {
        if (is_array($originalArray) && is_array($Changedkeys)) {
    		$newArr = array();
    		foreach ($originalArray as $k => $v) {
                if (!in_array($k, $deletedFields)) {
                    $originalArray = array_diff_key($originalArray, [$k]);
                    $key = array_key_exists( $k, $Changedkeys) ? $Changedkeys[$k] : $k;
                    $newArr[$key] = is_array($v) ? $this->recursiveChangeKey($v, $Changedkeys, $deletedFields) : $v;
                }
    		}
    		return $newArr;
    	}
    	return $originalArray;
    }

    /**
     * get all necessary feilds in array from yaml file
     */
    private function getFields(array $array) :array
    {
        return array_filter(array_combine(array_keys($array['Mapping']['fields']), array_column($array['Mapping']['fields'], 'column')));
    }

    /**
     * get all feilds which are should be deleted in array from yaml file
     */
    private function getDeletedFields(array $array) :array
    {
        return array_keys($array['Mapping']['deletedFields']);
    }

    /**
     * convert array to json
     */
    private function convertToJson(array $array)
    {
        return json_encode($array);
    }
}
