<?php

/**
 * Convert an object to an associative array.
 *
 * @param object|array $arrObjData
 * @param array $arrSkipIndices
 * @return array
 */
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

/**
 * Constructor helper for QueryResult.
 *
 * @param mixed $items
 * @param \ITCity\Rivile\QueryBuilder $query
 * @return \ITCity\Rivile\QueryResult
 */
function query_result ($items, $query) {
	return new ITCity\Rivile\QueryResult($items, $query);
}

/**
 * Convert an array to SimpleXMLElement.
 *
 * @param array $arr
 * @param \SimpleXMLElement $xml Root element
 * @return \SimpleXMLElement
 */
function array_to_xml(array $arr, SimpleXMLElement $xml) {
    foreach ($arr as $k => $v) {
        is_array($v)
            ? array_to_xml($v, $xml->addChild($k))
            : $xml->addChild($k, $v);
    }
    return $xml;
}
