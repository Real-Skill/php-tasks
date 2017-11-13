<?php

class OAuth2Test extends TestCase
{
    use \Illuminate\Foundation\Testing\DatabaseTransactions;

    protected $authenticationPayload = [
        'email' => 'hakier@fake.pl',
        'password' => 'hakier-password',
    ];

    /**
     * @before
     */
    public function seedUsersAndTruncateOAuthTables()
    {
        $this->seed(UsersTableSeeder::class);

        DB::table('oauth_access_tokens')->truncate();
        DB::table('oauth_auth_codes')->truncate();
        DB::table('oauth_clients')->truncate();
        DB::table('oauth_personal_access_clients')->truncate();
        DB::table('oauth_refresh_tokens')->truncate();
    }

    /**
     * @return $this
     */
    protected function authenticate()
    {
        return $this->visit('login')->submitForm('Login', $this->authenticationPayload)->seePageIs('/home');
    }

    /**
     * @test
     */
    public function shouldCreatePersonalAccessTokenAndAllowToAccessApiUsingIt()
    {
        Artisan::call('passport:install');

        $this->authenticate();

        $this->json('POST', 'oauth/personal-access-tokens', [
            'name' => 'personalAccessToken',
        ]);

        $this->json('GET', '/api/user', [], ['Authorization' => 'Bearer '.$this->decodeResponseJson()['accessToken']]);

        $this->seeJson([
            'name' => 'Hakier',
            'email' => 'hakier@fake.pl',
        ]);
    }

    /**
     * @test
     */
    public function shouldCreateOAuthClient()
    {
        $this->authenticate();

        $this->notSeeInDatabase('oauth_clients', ['name' => 'client']);

        // create oauth client
        $this->json('POST', 'oauth/clients', [
            'name' => 'client',
            'redirect' => 'http://127.0.0.1:8000/callback',
        ]);
        $response = $this->decodeResponseJson();

        $this->seeInDatabase('oauth_clients', ['name' => 'client']);

        // create client to check if three legged oauth works
        $client = new \Goutte\Client();
        $query = http_build_query([
            'client_id' => $response['user_id'],
            'redirect_uri' => 'http://127.0.0.1:8000/callback',
            'response_type' => 'code',
            'scope' => '',
        ]);
        // visit oauth/authorize which will display login form
        $crawler = $client->request('GET', 'http://127.0.0.1:8000/oauth/authorize?'.$query);
        // submit authentication data to login form
        $crawler = $client->submit($crawler->selectButton('Login')->form($this->authenticationPayload));
        // do not follow redirects to extract generated authentication code
        $client->followRedirects(false);
        // authorize our request
        $client->submit($crawler->selectButton('Authorize')->form());
        $crawler = $client->followRedirect();
        // extract authorization code
        $code = \GuzzleHttp\Psr7\parse_query(preg_replace('#.*/callback#', '', $crawler->getUri()))['?code'];
        // obtain access token
        $http = new GuzzleHttp\Client();
        $response = $http->post('http://127.0.0.1:8000/oauth/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => $response['user_id'],
                'client_secret' => $response['secret'],
                'redirect_uri' => 'http://127.0.0.1:8000/callback',
                'code' => $code
            ],
        ]);
        // extract access token and use it to perform request of user data
        $this->json('GET', '/api/user', [], ['Authorization' => 'Bearer '.json_decode((string)$response->getBody())->access_token]);
        // assert that proper data has been returned
        $this->seeJson([
            'name' => 'Hakier',
            'email' => 'hakier@fake.pl',
        ]);
    }
}
