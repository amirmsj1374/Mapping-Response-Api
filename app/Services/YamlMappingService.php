<?php

namespace App\Services;

use Yaml;

class YamlMappingService
{
    public function getData(array $originalArray)
    {
        $keys = file_get_contents(database_path('mapping.yml'));
        $yamlArray = Yaml::parse($keys);
        $fields = $this->getFields($yamlArray);
        $deletedFields = $this->getDeletedFields($yamlArray);
        return $this->recursiveChangeKey($originalArray, $fields, $deletedFields);
    }

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

    private function getFields(array $array) :array
    {
        return array_filter(array_combine(array_keys($array['Mapping']['fields']), array_column($array['Mapping']['fields'], 'column')));
    }

    private function getDeletedFields(array $array) :array
    {
        return array_keys($array['Mapping']['deletedFields']);
    }

    private function convertToJson(array $array)
    {
        return json_encode($array);
    }
}
