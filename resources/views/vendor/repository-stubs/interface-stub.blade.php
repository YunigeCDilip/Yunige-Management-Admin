namespace App\Application\Contracts;

interface  {{ $command->getClassName($command->repositoryName) }}Contract
{
    /**
     *
     * @return mixed
     */
    public function index();

    /**
     *
     * @return mixed
     */
    public function all();

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function store($request);

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function show($id);

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function edit($id);

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function update($request, $id);

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function destroy($request, $id);
}
