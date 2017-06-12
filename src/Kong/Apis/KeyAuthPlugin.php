<?php

namespace Ignittion\Kong\Apis;
use Unirest\Request as RestClient;

class KeyAuthPlugin extends AbstractApi
{
    /**
     * Allowed API options
     *
     * @var array
     */
    protected $allowedOptions = [];

    /**
     * List or get a specific consumer. $user can be id or username
     *
     * @see https://getkong.org/docs/0.6.x/admin-api/#list-consumers
     * @see https://getkong.org/docs/0.6.x/admin-api/#retrieve-consumer
     *
     * @param null|string $user
     * @param array $params
     * @return \stdClass
     */
    public function get($user = null, array $params = [])
    {
        $uri    = 'consumers' . ($user ? "/{$user}/key-auth" : "");
        return $this->call('get', $uri, $params);
    }

    /**
     * Create a new consumer
     *
     * @see https://getkong.org/docs/0.6.x/admin-api/#create-consumer
     *
     * @param array $options
     * @return \stdClass
     */
    public function create($user)
    {
    	$headers = array('Accept' => '*/*', 'Content-Type' => 'application/x-www-form-urlencoded', 'Content-Length' => '0');
        $body = array('');
        $uri = "{$this->url}:{$this->port}/consumers/{$user}/key-auth";
        $response = RestClient::post($uri, $headers, $body);

        $object             = new \stdClass();
        $object->code       = $response->code;
        $object->data       = $response->body;

        return $object;
    }

    /**
     * Update a Consumer
     *
     * @param string $user
     * @param array $options
     * @return \stdClass
     */
    public function update($user, array $options = [])
    {
        $body   = $this->createRequestBody($options);
        return $this->call('patch', "consumers/{$user}", [], $body);
    }

    /**
     * Update or Create a Consumer
     *
     * @param array $options
     * @return \stdClass
     */
    public function upsert(array $options = [])
    {
        $body   = $this->createRequestBody($options);
        return $this->call('put', "consumers", [], $body);
    }

    /**
     * Delete a Consumer
     *
     * @param string $user
     * @return boolean
     */
    public function delete($user, $id)
    {
        $resp   = $this->call('delete', "consumers/{$user}/key-auth/{$id}");
        return ($resp->code == 204);
    }
}