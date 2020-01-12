<?php

namespace helpers;


class Validator
{
	public static function is_email(string $string) : bool
	{
		// EXPLAIN: filter_var() returns the filtered data, or FALSE if the filter fails.
		// REPORT: Reported as bug to php.net
		if (filter_var($string, FILTER_VALIDATE_EMAIL)) 
		{
			return true;
		}
		
		return false;
	}


	public static function is_alnum(string $string) : bool
	{
		return ctype_alnum(str_replace(' ', '', $string));
	}


}