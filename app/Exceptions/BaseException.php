<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class BaseException extends Exception
{
    
    protected int $statusCode = 500 ; 
    public string $view ;
    public function __construct(string $message = null, string $view = null, int $statusCode = null  ){
        $this->view  = $view ?? $this->getDefaultView() ; 
        $this->statusCode = $statusCode ?? $this->statusCode ; 

        parent::__construct($message ?? $this->getDefaultMessage() , 0); 
    }
    protected function getDefaultMessage(){
        return 'Something Went Wrong';
    }
    protected function getDefaultView(){
        return 'Application.errors.generic';
    }
    public function render(Request $request){
        // $request dedict if request->expectedJson for api purposes ; 

        return response()->view($this->view , [
            'message'=>$this->getMessage() , 
            'status' => $this->statusCode , 
        ] , $this->statusCode);
    }
}
