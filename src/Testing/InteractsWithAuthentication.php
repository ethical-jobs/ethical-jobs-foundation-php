<?php

namespace EthicalJobs\Foundation\Testing;

/**
 * Authentication testing trait
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

trait InteractsWithAuthentication
{
    /**
     * Creates a password grant client
     *
     * @return Laravel\Passport\PersonalAccessClient
     */
    public function createPasswordGrantClient()
    {
        $clients = app()->make(\Laravel\Passport\ClientRepository::class);
        $client = $clients->createPersonalAccessClient(null, 'test-client', 'http://localhost');

        $accessClient = new \Laravel\Passport\PersonalAccessClient();
        $accessClient->client_id = $client->id;
        $accessClient->save();

        return $accessClient;
    }
}