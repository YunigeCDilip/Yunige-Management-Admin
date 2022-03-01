namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Application\Services\{{$command->getClassName($command->repositoryName)}}Service;
@if ($command->createRequestName)
use App\Http\Requests{{$command->getNamespace($command->createRequestName)}}\{{$command->getClassName($command->createRequestName)}};
@endif
@if ($command->updateRequestName && $command->createRequestName != $command->updateRequestName)
use App\Http\Requests{{$command->getNamespace($command->updateRequestName)}}\{{$command->getClassName($command->updateRequestName)}};
@endif
use Throwable;

class {{$command->getClassName($command->repositoryName)}}Controller extends Controller 
{
    /**
     * @var $service
     */
    protected $service;

    public function __construct( 
        {{$command->getClassName($command->repositoryName)}}Service $service
    )
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->service->index();

        return $data;
    }

    /**
     * Return all active data for view.
     *
     * @return Response
     */
    public function all()
    {
        $data = $this->service->all();

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param {{$command->getClassName($command->createRequestName)}} $request
     * @return Response
     */
    public function store({{$command->getClassName($command->createRequestName)}} $request)
    {
        $data = $this->service->store($request);

        return $data;
    }

    /**
     * Show the form for showing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = $this->service->show($id);

        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data = $this->service->edit($id);

        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param {{$command->getClassName($command->updateRequestName)}} $request
     * @param int $id
     * @return Response
     */
    public function update({{$command->getClassName($command->updateRequestName)}} $request, $id)
    {
        $data = $this->service->update($request, $id);

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $data = $this->service->destroy($request, $id);

        return $data;
    }
}
