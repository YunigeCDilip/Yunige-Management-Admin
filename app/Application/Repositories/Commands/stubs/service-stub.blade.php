namespace App\Application\Services;

use Illuminate\Support\Facades\Log;
use App\Application\Contracts\{{$command->getClassName($command->repositoryName)}}Contract;
use Throwable;

class {{ $command->getClassName($command->repositoryName) }}Service
{
    /**
     *
     * @var {{$command->getClassName($command->repositoryName)}} $contract
    */
    protected $contract;

    public function __construct(
        {{$command->getClassName($command->repositoryName)}}Contract $contract
    ){
        $this->contract = $contract;
    }

    /**
     * Return required data for view.
     *
     * @return Response
     */
    public function index(){
        try {
            $data = $this->contract->index();

            return $data;
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
        }
    }

    /**
     * Return all active data for view.
     *
     * @return Response
     */
    public function all(){
        try {
            $data = $this->contract->all();

            return $data;
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store($request){
        try {
            $data = $this->contract->store($request);

            return $data;
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
        }
    }

    /**
     * Show the form for showing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        try {
            $data = $this->contract->show($id);

            return $data;
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        try {
            $data = $this->contract->edit($id);

            return $data;
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update($request, $id)
    {
        try {
            $data = $this->contract->update($request, $id);

            return $data;
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($request, $id)
    {
        try {
            $data = $this->contract->destroy($request, $id);

            return $data;
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
        }
    }
}
