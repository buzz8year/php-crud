<?php

namespace app;

class View 
{
    protected $template = null;

    public function __construct(string $template) 
    {
        $this->template = $template;
    }

    public function render(array $data) 
    {
        include('../src/views/' . $this->template . '.php');
        
        ob_start();
        ob_get_clean();
    }
    
}
