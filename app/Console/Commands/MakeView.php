<?php

namespace App\Console\Commands;

use File;
use Illuminate\Console\Command;
use function PHPUnit\Framework\directoryExists;

class MakeView extends Command
{
   
    protected $signature = 'make:view 
    {path : Dot notation path (e.g. home.index)}
    {--force : Overwrite if file exists}
    {--layout= : Wrap the view with a layout (e.g. layouts.app)}';

    protected $description = 'Create a new Blade view file';

    
    public function handle()
    {
        // Get Path-Argument ; 
        $argument = $this->argument('path');
        $path = $this->get_full_path($argument);
        
        $this->check_directory($path);
        

        if (File::exists($path) && !$this->option('force')) {
            $this->error("❌ View already exists at: {$path}");
            $this->warn("👉 Use --force to overwrite.");
            return;
        }

        // Create Path ;
        File::put($path, $this->generateViewContent($argument));
        $this->info("{$path} Created");
    }

    protected function get_full_path($path){
        $path = str_replace('.','/',$path);
        return 'resources/views/' . $path . '.blade.php';
    }

    protected function check_directory($path){
        // Create directory if it doesn't exist
        $dirName = dirname($path);
        if (!file_exists($dirName)) {
            $this->info("📁 Directory created: {$dirName}");
            mkdir($dirName, 0777, true);
        }

        return true;
    }

    protected function generateViewContent($viewName)
    {
        $layout = $this->option('layout');
        if ($layout) {
            return <<<BLADE
                    <x-app
                    {{-- __('index.products') for translation --}}
                    :title="__('index.products')"
                    :show_bread_crump="true"
                    :breadcumptitle="__('index.products')"
                    >
                    <!-- Content -->
                    </x-app>

                BLADE;
            }

        return <<<BLADE
        <!-- View: {$viewName} -->

        <h1>{$viewName}</h1>
        BLADE;
    }
        
}
