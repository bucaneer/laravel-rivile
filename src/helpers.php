<?php

function object2array($arrObjData, $arrSkipIndices = array()) {
	$arrData = array();

	if (is_object($arrObjData)) {
		$arrObjData = get_object_vars($arrObjData);
	}

	if (is_array($arrObjData)) {
		foreach ($arrObjData as $index => $value) {
			if (is_object($value) || is_array($value)) {
				$value = object2array($value, $arrSkipIndices);
			}
			if (in_array($index, $arrSkipIndices)) continue;

			$arrData[$index] = (empty($value)) ? NULL : $value;
		}
	}
	return $arrData;
}

function query_result ($items, $query) {
	return new ITCity\Rivile\QueryResult($items, $query);
}

function array_to_xml(array $arr, SimpleXMLElement $xml) {
    foreach ($arr as $k => $v) {
        is_array($v)
            ? array_to_xml($v, $xml->addChild($k))
            : $xml->addChild($k, $v);
    }
    return $xml;
}
