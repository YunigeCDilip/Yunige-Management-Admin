namespace App\Observers;

use App\Models\{{$command->getClassName($command->modelName)}};

class {{$command->getClassName($command->observerName)}}
{
    /**
     * Handle the {{$command->getClassName($command->modelName)}} "created" event.
     *
     * @param  \App\Models\{{$command->getClassName($command->modelName)}}  ${{$command->getClassName($command->modelName)}}
     * @return void
     */
    public function created({{$command->getClassName($command->modelName)}} ${{$command->getClassName($command->modelName)}})
    {
    }

    /**
     * Handle the {{$command->getClassName($command->modelName)}} "updated" event.
     *
     * @param  \App\Models\{{$command->getClassName($command->modelName)}}  ${{$command->getClassName($command->modelName)}}
     * @return void
     */
    public function updated({{$command->getClassName($command->modelName)}} ${{$command->getClassName($command->modelName)}})
    {
    }

    /**
     * Handle the {{$command->getClassName($command->modelName)}} "deleted" event.
     *
     * @param  \App\Models\{{$command->getClassName($command->modelName)}}  ${{$command->getClassName($command->modelName)}}
     * @return void
     */
     public function deleted({{$command->getClassName($command->modelName)}} ${{$command->getClassName($command->modelName)}})
    {
        //
    }

    /**
     * Handle the {{$command->getClassName($command->modelName)}} "restored" event.
     *
     * @param  \App\Models\{{$command->getClassName($command->modelName)}}  ${{$command->getClassName($command->modelName)}}
     * @return void
     */
    public function restored({{$command->getClassName($command->modelName)}} ${{$command->getClassName($command->modelName)}})
    {
        //
    }

    /**
     * Handle the {{$command->getClassName($command->modelName)}} "force deleted" event.
     *
     * @param  \App\Models\{{$command->getClassName($command->modelName)}}  ${{$command->getClassName($command->modelName)}}
     * @return void
     */
    public function forceDeleted({{$command->getClassName($command->modelName)}} ${{$command->getClassName($command->modelName)}})
    {
        //
    }
}
