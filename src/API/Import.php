<?php

namespace Tngnt\PBI\API;

use Tngnt\PBI\Client;
use Tngnt\PBI\Model\Import as ImportModel;

/**
 * Class Import
 *
 * @package Tngnt\PBI\API
 */
class Import
{
    const IMPORT_URL = "https://api.powerbi.com/v1.0/myorg/imports";
    const GROUP_IMPORT_URL = 'https://api.powerbi.com/v1.0/myorg/groups/%s/imports';
    const CONFLICT_IGNORE = 'Ignore';
    const CONFLICT_ABORT = 'Abort';
    const CONFLICT_OVERWRITE = 'Overwrite';
    const CONFLICT_CREATEOROVERWRITE = 'CreateOrOverwrite';

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
     * Creates an import on PowerBI
     *
     * @param ImportModel $import         The import to create
     * @param string $groupId             The group Id to create
     * @param string $datasetDisplayName  A custom display name. Blank to ignore.
     * @param string $nameConflict        What to do when there is a name conflict. Either "Ignore", "Abort", "Overwrite" or "CreateOrOverwrite"
     *
     * @return \Tngnt\PBI\Response
     */
    public function createImport(ImportModel $import, $groupId = null, $datasetDisplayName, $nameConflict = self::CONFLICT_CREATEOROVERWRITE)
    {
        $url = $this->getUrl($groupId);

        $boundary = "----------BOUNDARY";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . '?nameConflict='.$nameConflict.'&datasetDisplayName=' . $datasetDisplayName);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $postdata = '';
        $postdata .= "--" . $boundary . "\r\n";
        $postdata .= "Content-Disposition: form-data\r\n";
        $postdata .= "Content-Type: application/octet-stream\r\n\r\n";
        $postdata .= file_get_contents($import->getFilePath());
        $postdata .= "\r\n";
        $postdata .= "--" . $boundary . "--\r\n";

        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer " . $this->client->token,
            'Content-Type: multipart/form-data; boundary=' . $boundary,
            'Content-Length: ' . strlen($postdata)
        ));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        if (curl_error($ch)) {
            return 'curl error';
        }
        curl_close($ch);

        return json_decode($response, true);

    }

    /**
     * Returns a list of imports from PowerBI
     *
     * @return \Tngnt\PBI\Response
     */
    public function getImports($groupId = null)
    {
        $url = $this->getUrl($groupId);

        $response = $this->client->request(Client::METHOD_GET, $url);

        return $this->client->generateResponse($response);
    }

    /**
     * Retrieves a specific import from PowerBI
     *
     * @param string $importId The ID of the import
     *
     * @return \Tngnt\PBI\Response
     */
    public function getImport($importId, $groupId = null)
    {
        $url = $this->getUrl($groupId) . '/' . $importId;

        $response = $this->client->request(Client::METHOD_GET, $url);

        return $this->client->generateResponse($response);
    }

    /**
     * Helper function to format the request URL
     *
     * @param null|string $groupId An optional group ID
     *
     * @return string
     */
    private function getUrl($groupId)
    {
        if ($groupId) {
            return sprintf(self::GROUP_IMPORT_URL, $groupId);
        }

        return self::IMPORT_URL;
    }
}
