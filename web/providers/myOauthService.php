<?php

namespace Project3\OAuth\Service;


include __DIR__ . '/../../vendor/lusitanian/oauth/src/OAuth/bootstrap.php';
include __DIR__ . '/AbstractService.php';


use Project3\OAuth2\Service\AbstractService;
use OAuth\OAuth2\Token\StdOAuth2Token;
use OAuth\Common\Http\Exception\TokenResponseException;
use OAuth\Common\Http\Uri\Uri;
use OAuth\Common\Consumer\CredentialsInterface;
use OAuth\Common\Http\Client\ClientInterface;
use OAuth\Common\Storage\TokenStorageInterface;
use OAuth\Common\Http\Uri\UriInterface;

/**
 * Box service.
 *
 * @author Antoine Corcy <contact@sbin.dk>
 * @link https://developers.box.com/oauth/
 */
class MyOauthService extends AbstractService
{
    public function __construct(
        CredentialsInterface $credentials,
        ClientInterface $httpClient,
        TokenStorageInterface $storage,
        $scopes = array(),
        UriInterface $baseApiUri = null
    ) {
        parent::__construct($credentials, $httpClient, $storage, $scopes, $baseApiUri, true);

        if (null === $baseApiUri) {
            $this->baseApiUri = new Uri('http://localhost:8899/oauth');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthorizationEndpoint()
    {
//        return new Uri('http://localhost:8080/lockdin/authorize');
//        printToTerminal('getAuthorizationEndpoint');
        return new Uri('http://localhost:8899/oauth/authorize');
    }

    /**
     * {@inheritdoc}
     */
    public function getAccessTokenEndpoint()
    {
//        return new Uri('http://localhost:8080/lockdin/token');
//        printToTerminal('getAccessTokenEndpoint');
        return new Uri('http://localhost:8899/oauth/token');
    }

    /**
     * {@inheritdoc}
     */
    protected function getAuthorizationMethod()
    {
        return static::AUTHORIZATION_METHOD_HEADER_BEARER;
//        return static::AUTHORIZATION_METHOD_QUERY_STRING;
//        return 6;
    }

    /**
     * {@inheritdoc}
     */
    protected function parseAccessTokenResponse($responseBody)
    {
        printToTerminal('MyOauthService:    ');
        $data = json_decode($responseBody, true);

        if (null === $data || !is_array($data)) {
            throw new TokenResponseException('Unable to parse response.');
        } elseif (isset($data['error'])) {
            throw new TokenResponseException('Error in retrieving token: "' . $data['error'] . '"');
        }

        $token = new StdOAuth2Token();
        $token->setAccessToken($data['access_token']);
        $token->setLifeTime($data['expires_in']);

        if (isset($data['refresh_token'])) {
            $token->setRefreshToken($data['refresh_token']);
            unset($data['refresh_token']);
        }

        unset($data['access_token']);
        unset($data['expires_in']);

        $token->setExtraParams($data);

        return $token;
    }
}
