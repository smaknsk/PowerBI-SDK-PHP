<?php

namespace Tngnt\PBI\API;

use Tngnt\PBI\Client;

/**
 * Class Gateway
 *
 * @package Tngnt\PBI\API
 */
class Gateway
{
    const GATEWAY_URL = "https://api.powerbi.com/v1.0/myorg/gateways";
    const DATASOURCES_URL = "https://api.powerbi.com/v1.0/myorg/gateways/%s/datasources";
    const DATASOURCES_UPDATE_URL = "https://api.powerbi.com/v1.0/myorg/gateways/%s/datasources/%s";
    const DATASOURCES_STATUS_URL = "https://api.powerbi.com/v1.0/myorg/gateways/%s/datasources/%s/status";

    /**
     * The SDK client
     *
     * @var Client
     */
    private $client;

    /**
     * Table constructor.
     *
     * @param Client $client The SDK client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Returns a list of gateways the user is admin on
     * https://docs.microsoft.com/en-us/rest/api/power-bi/gateways/getgateways
     *
     * @return \Tngnt\PBI\Response
     */
    public function getGateways()
    {
        $response = $this->client->request(Client::METHOD_GET, self::GATEWAY_URL);

        return $this->client->generateResponse($response);
    }

    /**
     * Returns a list of datasources from the specified gateway
     * https://docs.microsoft.com/en-us/rest/api/power-bi/gateways/getdatasources
     *
     * @param $gatewayId
     * @return \Tngnt\PBI\Response
     */
    public function getDatasources($gatewayId)
    {
        $url = sprintf(self::DATASOURCES_URL, $gatewayId);

        $response = $this->client->request(Client::METHOD_GET, $url);

        return $this->client->generateResponse($response);
    }

    /**
     * Checks the connectivity status of the specified datasource from the specified gateway
     * https://docs.microsoft.com/en-us/rest/api/power-bi/gateways/getdatasourcestatusbyid
     *
     * @param $gatewayId
     * @return \Tngnt\PBI\Response - return NULL if no error
     */
    public function getDatasourcesStatus($gatewayId, $datasourceId)
    {
        $url = sprintf(self::DATASOURCES_STATUS_URL, $gatewayId, $datasourceId);

        $response = $this->client->request(Client::METHOD_GET, $url);

        return $this->client->generateResponse($response);
    }

    /**
     * Create a new datasource on the specified gateway
     * https://docs.microsoft.com/en-us/rest/api/power-bi/gateways/createdatasource
     *
     * @param string $gatewayId
     * @param array $data
     * @return \Tngnt\PBI\Response
     */
    public function createDatasource($gatewayId, $data)
    {
        $url = sprintf(self::DATASOURCES_URL, $gatewayId);

        $response = $this->client->request(Client::METHOD_POST, $url, $data);

        return $this->client->generateResponse($response);
    }

    /**
     * Updates the credentials of the specified datasource from the specified gateway
     * https://docs.microsoft.com/en-us/rest/api/power-bi/gateways/updatedatasource
     * https://msdn.microsoft.com/en-us/library/mt784645.aspx
     *
     * @param string $gatewayId    The ID of the gateway
     * @param string $datasourceId The ID of the datasource
     * @param array  $credentials  The credentials in the following format: ['credentialsType' => 'basic',
     *                             'basicCredentials' => ['username' => '', 'password' => '']]
     *
     * @return \Tngnt\PBI\Response
     */
    public function updateDatasource($gatewayId, $datasourceId, array $credentials)
    {
        $url = sprintf(self::DATASOURCES_UPDATE_URL, $gatewayId, $datasourceId);

        $response = $this->client->request(Client::METHOD_PATCH, $url, $credentials);

        return $this->client->generateResponse($response);
    }
}
