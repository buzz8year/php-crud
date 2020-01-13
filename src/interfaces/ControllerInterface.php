<?php

namespace interfaces;


interface ControllerInterface
{
	public function refresh();
	public function redirect(string $query);
	public function view(string $template, array $data);
}