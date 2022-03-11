<?php

namespace App\Airtable;

use App\Airtable\ApiClient;

class AirTable
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * AirTable constructor.
     * @param Client $client
     */
    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param mixed $table
     * 
     * @return [type]
     */
    public function table($table)
    {
        $this->client->setTable($table);
    }

    /**
     * @param $data
     * @return \AirTable\Models\Interfaces\RecordInterface
     */
    public function create($data)
    {
        return $this->client->post($data);
    }

    /**
     * @param string $id
     * @param $data
     * @return \AirTable\Models\Interfaces\RecordInterface
     */
    public function update(string $id, $data)
    {
        return $this->client->put($id, $data);
    }

    /**
     * @param string $id
     * @return \AirTable\Models\Interfaces\RecordInterface
     */
    public function find(string $id)
    {
        return $this->client->get($id);
    }

    /**
     * @param string $id
     * @return \AirTable\Models\Interfaces\RecordInterface
     */
    public function delete(string $id)
    {
        return $this->client->delete($id);
    }

    /**
     * @return \AirTable\Models\Interfaces\RecordInterface[]|\AirTable\Models\Interfaces\TableInterface
     */
    public function get()
    {
        return $this->client->get();
    }

    /**
     * @param array $data
     * @return \AirTable\Models\Interfaces\RecordInterface|mixed
     */
    public function firstOrCreate(array $data)
    {
        foreach ($data as $field => $value) {
            $this->where($field, "=", $value);
        }

        $records = $this->get();

        if($records->count()) {
            return $records[0];
        } else {
            return $this->create($data);
        }
    }

    /**
     * @param array $data
     * @return \AirTable\Models\Interfaces\RecordInterface
     */
    public function updateOrCreate(array $data)
    {
        foreach ($data as $field => $value) {
            $this->where($field, "=", $value);
        }

        $records = $this->get();

        if ($records->count()) {
            $item = $records[0];

            return $this->update($item->getId(), $data);
        } else {
            return $this->create($data);
        }
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->client->all();
    }

    /**
     * @param array $fields
     * @return $this
     */
    public function fields(array $fields)
    {
        $this->client->fields($fields);

        return $this;
    }

    /**
     * @param string $column
     * @param string $operator
     * @param string $value
     * @return $this
     */
    public function where(string $column, string $operator, string $value)
    {
        $this->client->filterByFormula($column, $operator, $value);

        return $this;
    }

    /**
     * @param string $column
     * @param string $direction
     * @return $this
     */
    public function orderBy(string $column, string $direction)
    {
        $this->client->sort($column, $direction);

        return $this;
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function limit(int $limit)
    {
        $this->client->maxRecords($limit);

        return $this;
    }
}