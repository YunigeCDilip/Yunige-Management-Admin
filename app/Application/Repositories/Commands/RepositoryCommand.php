<?php

namespace App\Application\Repositories\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RepositoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create repository design pattern classes as per required';
    public $repositoryName;
    public $controllerName;
    public $modelName;
    public $resourceName;
    public $createRequestName;
    public $updateRequestName;
    public $observerName;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        File::copyDirectory(app_path("/Application/Repositories/Commands/stubs"), resource_path("/views/vendor/repository-stubs"));

        $this->askQuestions();

        return 0;
    }

    public function askQuestions()
    {
        $this->repositoryName = $this->ask("Repository Name?");

        while (empty($this->repositoryName)) {
            $this->error('Invalid Repository Class Name');
            $this->repositoryName = $this->ask("Repository Name?");
        }

        $validName = false;
        while (!$validName) {
            $this->controllerName = $this->ask("Controller Name?");
            $validName = true;
            if (!empty($this->controllerName) && !$this->validClassName($this->controllerName)) {
                $validName = false;
            }
        }

        $this->modelName = $this->ask("Model name?");
        if (!empty($this->modelName) && !$this->validClassName($this->modelName)) {
            $this->modelName = '';
        }

        while (empty($this->modelName)) {
            $this->error('Invalid Model Name');
            $this->modelName = $this->ask("Model name?");
        }

        /**
         *
         */
        if ($this->modelName) {
            $validName = false;
            while (!$validName) {
                $this->observerName = $this->ask("Observer Name?");
                $validName = true;
                if (!empty($this->observerName) && !$this->validClassName($this->observerName)) {
                    $validName = false;
                }
            }

            $validName = false;
            while (!$validName) {
                $this->resourceName = $this->ask("API Resource Name?");
                $validName = true;
                if (!empty($this->resourceName) && !$this->validClassName($this->resourceName)) {
                    $validName = false;
                }
            }
        }


        $validName = false;
        while (!$validName) {
            $this->createRequestName = $this->ask("Create Request name?");
            $validName = true;
            if (!empty($this->createRequestName) && !$this->validClassName($this->createRequestName)) {
                $validName = false;
            }
        }

        $validName = false;
        while (!$validName) {
            $this->updateRequestName = $this->ask("Update Request name?");
            $validName = true;
            if (!empty($this->updateRequestName) && !$this->validClassName($this->updateRequestName)) {
                $validName = false;
            }
        }

        $this->createObserver();
        $this->createResource();
        $this->createRequests();
        $this->createRepositoryContract();
        $this->createServiceContract();
        $this->createRepository();
        $this->createController();
    }

    public function createObserver()
    {
        $filePath = app_path('Observers/') . ucwords($this->observerName) . ".php";
        if (!empty($this->observerName)) {
            $this->createFile($filePath, 'vendor.repository-stubs.observer-stub', 'Observers');
        }
    }

    public function createResource()
    {
        if (!empty($this->resourceName)) {
            $filePath = app_path('Http/Resources/') . ucwords($this->resourceName) . ".php";
            $this->createFile($filePath, 'vendor.repository-stubs.resource-stub', 'Resource');
        }
    }

    public function createRequests()
    {
        if (!empty($this->createRequestName)) {
            $filePath = app_path('Http/Requests/') . ucwords($this->createRequestName) . ".php";
            $this->createFile($filePath, 'vendor.repository-stubs.create-request-stub', 'Requests');
        }

        if (!empty($this->updateRequestName) && $this->createRequestName != $this->updateRequestName) {
            $filePath = app_path('Http/Requests/') . ucwords($this->updateRequestName) . ".php";
            $this->createFile($filePath, 'vendor.repository-stubs.update-request-stub', 'Requests');
        }
    }

    public function createRepositoryContract()
    {
        $filePath = app_path('Application/Contracts/') . ucwords($this->repositoryName) . "Contract.php";
        if (!empty($this->repositoryName)) {
            $this->createFile($filePath, 'vendor.repository-stubs.interface-stub', 'Repository contract');
        }
    }

    public function createServiceContract()
    {
        $filePath = app_path('Application/Services/') . ucwords($this->repositoryName) . "Service.php";
        if (!empty($this->repositoryName)) {
            $this->createFile($filePath, 'vendor.repository-stubs.service-stub', 'Repository service');
        }
    }

    public function checkFolderExists($path)
    {
        if (!file_exists($path)) {
            mkdir($path, 0775, true);
        }
    }

    public function createRepository()
    {
        $filePath = app_path('Application/Repositories/') . ucwords($this->repositoryName)."Repository.php";
        if (!empty($this->repositoryName)) {
            $this->createFile($filePath, 'vendor.repository-stubs.repository-stub', 'Repository');
        }
    }

    public function createController()
    {
        $filePath = app_path('Http/Controllers/Backend/') .ucwords($this->controllerName) . "Controller.php";
        if (!empty($this->controllerName)) {
            $this->createFile($filePath, 'vendor.repository-stubs.controller-stub', 'Controller');
        }
    }

    public function getNamespace($string): string
    {
        $parts = explode("/", $string);
        if (count($parts) > 1) {
            $namespaceParts = array_slice($parts, 0, -1);

            return "\\".implode('\\', $namespaceParts);
        }

        return '';
    }

    public function getClassName($string)
    {
        $parts = explode("/", $string);

        return ucwords(end($parts));
    }

    public function getControllerClassName()
    {
        $parts = explode("/", $this->controllerName);

        return ucwords(end($parts));
    }

    public function validClassName($className)
    {
        $className = str_replace('/', '', $className);
        $className = str_replace('\\', '', $className);
        return preg_match('/^[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*$/', $className);
    }

    public function createFile($filePath, $stubFile, $fileType, $variables = [])
    {
        if (file_exists($filePath)) {
            $this->error($fileType." already exists");
            return false;
        }

        $view = view($stubFile)
            ->with('command', $this)
            ->with('variables', $variables);
        $fileContent = '<?php

' . $view->render();
        $this->checkFolderExists(substr($filePath, 0, strrpos($filePath, "/")));
        File::put($filePath, $fileContent);
        $this->info($fileType." Created Successfully.");

        return 0;
    }
}
