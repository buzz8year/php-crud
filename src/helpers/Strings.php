<?php

namespace helpers;

class Strings
{
	public static function prepareOrderBy(string $orderBy, string $default) : ?string
	{
        if (empty($orderBy)) 
        {
            $orderBy = $default;
        }

        // EXPLAIN: ...
        if (strpos($orderBy, '-') === false) 
        {
            $orderBy .= ' ASC';
        }
        else 
        {
            $orderBy = trim($orderBy, '-');
            $orderBy .= ' DESC';
        }	

        return $orderBy;
	}

	
}