<?php

namespace Ignittion\Kong\Apis;

class RateLimitPlugin extends AbstractApi
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
    public function get($user, array $params = [])
    {
        $plugin = new Plugin($this->url, $this->port);

        return $plugin->perConsumerAndName($user, 'rate-limiting');
    }

    /**
     * Create a new consumer
     *
     * @see https://getkong.org/docs/0.6.x/admin-api/#create-consumer
     *
     * @param array $options
     * @return \stdClass
     */
    public function create($apiId, array $options = [])
    {
        $body   = $this->createRequestBody($options);
        return $this->call('post', "apis/{$apiId}/plugins", [], $body);
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
    public function delete($id)
    {
        $resp   = $this->call('delete', "plugins/{$id}");
        return ($resp->code == 204);
    }
}