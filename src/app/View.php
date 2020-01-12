<?php

namespace app;

class View 
{
    // EXPLAIN: ...
    protected $template = null;

    
    // EXPLAIN: ...
    public function __construct(string $template) 
    {
        $this->template = $template;
    }

    
    // EXPLAIN: ...
    public function render(array $data) 
    {
        include('../src/views/' . $this->template . '.php');
        
        ob_start();
        ob_get_clean();
    }
    

}