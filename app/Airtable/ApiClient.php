<?php

namespace App\Airtable;

interface ApiClient
{
    public function post($contents = null);

    public function put(string $id, $contents = null);

    public function patch(string $id, $contents = null);

    public function delete(string $id);
}