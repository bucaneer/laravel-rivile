<?php

namespace ITCity\Rivile;

use Illuminate\Database\Query\Grammars\Grammar;

class QueryGrammar extends Grammar{
	public function whereString(QueryBuilder $query) {
		if (is_null($query->wheres)) {
            return '';
        }

        if (count($sql = $this->compileWheresToArray($query)) > 0) {
            return $this->removeLeadingBoolean(implode(' ', $sql));
        }

        return '';
	}

	protected function compileWheresToArray($query)
    {
        return collect($query->wheres)->map(function ($where) use ($query) {
            if (isset($where['column'])) $where['column'] = $this->processColumn($query, $where['column']);
            return $where['boolean'].' '.$this->{"where{$where['type']}"}($query, $where);
        })->all();
    }

    protected function processColumn($query, $column) {
    	return $query->rivile_object::attrName($column);
    }
}