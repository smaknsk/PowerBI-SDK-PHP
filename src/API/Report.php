<?php

namespace Tngnt\PBI\API;

use Tngnt\PBI\Client;
/**
 * Class Report
 *
 * @package Tngnt\PBI\API
 */
class Report
{
    const REPORT_URL = "https://api.powerbi.com/v1.0/myorg/reports";
    const GROUP_REPORT_URL = "https://api.powerbi.com/v1.0/myorg/groups/%s/reports";

    const GROUP_REPORT_EMBED_URL = "https://api.powerbi.com/v1.0/myorg/groups/%s/reports/%s/GenerateToken";

    const CLONE_URL = "https://api.powerbi.com/v1.0/myorg/reports/%s/Clone";
    const GROUP_CLONE_URL = "https://api.powerbi.com/v1.0/myorg/groups/%s/reports/%s/Clone";

    const REBIND_URL = "https://api.powerbi.com/v1.0/myorg/reports/%s/Rebind";
    const GROUP_REBIND_URL = "https://api.powerbi.com/v1.0/myorg/groups/%s/reports/%s/Rebind";


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
     * Retrieves a list of reports on PowerBI
     *
     * @param null|string $groupId An optional group ID
     *
     * @return \Tngnt\PBI\Response
     */
    public function getReports($groupId = null)
    {
        $url = self::REPORT_URL;

        if ($groupId) {
            $url = sprintf(self::GROUP_REPORT_URL, $groupId);
        }

        $response = $this->client->request(Client::METHOD_GET, $url);

        return $this->client->generateResponse($response);
    }

    /**
     * Retrieves the embed token for embedding a report
     *
     * @param string      $reportId    The report ID of the report
     * @param string      $groupId     The group ID of the report
     * @param null|string $accessLevel The access level used for the report
     *
     * @return \Tngnt\PBI\Response
     */
    public function getReportEmbedToken($reportId, $groupId, $accessLevel = 'view')
    {
        $url = sprintf(self::GROUP_REPORT_EMBED_URL, $groupId, $reportId);

        $body = [
            'accessLevel' => $accessLevel,
        ];

        $response = $this->client->request(Client::METHOD_POST, $url, $body);

        return $this->client->generateResponse($response);
    }

    /**
     * @param $reportId
     * @return \Tngnt\PBI\Response
     */
    public function cloneReport($reportId, $groupId = null, $name = null, $targetModelId = null, $targetWorkspaceId = null)
    {
        if ($groupId) {
            $url = sprintf(self::GROUP_CLONE_URL, $groupId, $reportId);
        } else {
            $url = sprintf(self::CLONE_URL, $reportId);
        }

        $body = [];
        if ($name) $body['name'] = $name;
        if ($targetModelId) $body['targetModelId'] = $targetModelId;
        if ($targetWorkspaceId) $body['targetWorkspaceId'] = $targetWorkspaceId;

        $response = $this->client->request(Client::METHOD_POST, $url, $body);

        return $this->client->generateResponse($response);
    }

    public function rebindReport($reportId, $groupId = null, $datasetId)
    {
        if ($groupId) {
            $url = sprintf(self::GROUP_REBIND_URL, $groupId, $reportId);
        } else {
            $url = sprintf(self::REBIND_URL, $reportId);
        }

        $body = [
            'datasetId' => $datasetId
        ];

        $response = $this->client->request(Client::METHOD_POST, $url, $body);

        return $this->client->generateResponse($response);
    }
}
