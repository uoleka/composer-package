<?php
namespace Intellicore\Keygen;
use Illuminate\Support\ServiceProvider;

class KeygenServiceProvider extends ServiceProvider 
{
    public function boot() 
    {
        require_once 'Keygenerator.php';
    }

    public function register() 
    {
        
    
    }
}
