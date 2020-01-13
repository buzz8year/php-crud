<?php

namespace helpers;

class Strings
{
	public static function prepareOrderBy(string $orderBy, string $default) : ?string
	{
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