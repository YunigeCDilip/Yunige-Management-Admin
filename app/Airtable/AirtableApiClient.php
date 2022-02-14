<?php

namespace App\Airtable;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AirtableApiClient implements ApiClient
{
    /**
     * @var $client
     * @var $typecast
     * @var $base
     * @var $table
     * @var $delay
     * @var $filters
     * @var $fields
     * @var $sorts
     * @var $offset
     */
    private $client;
    private $typecast;
    private $base;
    private $table;
    private $delay;
    private $filters = [];
    private $fields = [];
    private $sorts = [];
    private $offset = false;

    /**
     * @param mixed $base
     * @param mixed $table
     * @param mixed $access_token
     * @param Http|null $client
     * @param bool $typecast
     * @param int $delayBetweenRequests
     */
    public function __construct($base, $table, $access_token, Http $client = null, $typecast = false, $delayBetweenRequests = 200000)
    {
        $this->base = $base;
        $this->table = $table;
        $this->typecast = $typecast;
        $this->delay = $delayBetweenRequests;

        $this->client = $client ?? $this->buildClient($access_token);
    }

    /**
     * Build client to connect to air table
     * 
     * @param mixed $access_token
     * 
     * @return [type]
     */
    private function buildClient($access_token)
    {
        return Http::withOptions([
            'base_uri' => config('services.airtable.base_url'),
            'headers' => [
                'Authorization' => "Bearer {$access_token}",
                'content-type' => 'application/json',
            ],
        ]);
    }

    /**
     * Set tables from airtable
     * 
     * @param mixed $table
     * 
     * @return AirtableApiClient
     */
    public function setTable($table): AirtableApiClient
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Create data in airtable
     * 
     * @param null $contents
     * 
     * @return [type]
     */
    public function post($contents = null)
    {
        $url = $this->getEndpointUrl();

        $params = ['fields' => (object) $contents, 'typecast' => $this->typecast];

        return $this->decodeResponse($this->client->post($url, $params));
    }

    /**
     * update data in airtable
     * 
     * @param string $id
     * @param null $contents
     * 
     * @return [type]
     */
    public function put(string $id, $contents = null)
    {
        $url = $this->getEndpointUrl($id);

        $params = ['fields' => (object) $contents, 'typecast' => $this->typecast];

        return $this->decodeResponse($this->client->put($url, $params));
    }

    /**
     * patch data in airtable
     * 
     * @param string $id
     * @param null $contents
     * 
     * @return [type]
     */
    public function patch(string $id, $contents = null)
    {
        $url = $this->getEndpointUrl($id);

        $params = ['fields' => (object) $contents, 'typecast' => $this->typecast];

        return $this->decodeResponse($this->client->patch($url, $params));
    }

    /**
     * Delete data in airtable
     * 
     * @param string $id
     * 
     * @return [type]
     */
    public function delete(string $id)
    {
        $url = $this->getEndpointUrl($id);

        return $this->decodeResponse($this->client->delete($url));
    }

    /**
     * decode response
     * 
     * @param mixed $response
     * 
     * @return [type]
     */
    public function decodeResponse($response)
    {
        $body = (string) $response->getBody();

        if ($body === '') {
            return [];
        }

        return collect(json_decode($body, true));
    }

    /**
     * Set fields
     * 
     * @param array|null $fields
     * 
     * @return AirtableApiClient
     */
    public function setFields(?array $fields): AirtableApiClient
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * reutrn endpoint url
     * 
     * @param string|null $id
     * 
     * @return string
     */
    protected function getEndpointUrl(?string $id = null): string
    {
        if ($id) {
            $url = '/v0/~/~/~';

            return Str::replaceArray('~', [
                $this->base,
                $this->table,
                $id,
            ], $url);
        }

        $url = '/v0/~/~';

        $url = Str::replaceArray('~', [
            $this->base,
            $this->table,
        ], $url);

        if ($query_params = $this->getQueryParams()) {
            $url .= '?'.http_build_query($query_params);
        }

        return $url;
    }

    /**
     * return query parameters
     * 
     * @return array
     */
    protected function getQueryParams(): array
    {
        $query_params = [];

        if ($this->filters) {
            $query_params['filterByFormula'] = 'AND('.implode(',', $this->filters).')';
        }

        if ($this->fields) {
            $query_params['fields'] = $this->fields;
        }

        if ($this->offset) {
            $query_params['offset'] = $this->offset;
        }

        if ($this->sorts) {
            $query_params['sort'] = $this->sorts;
        }

        return $query_params;
    }
}