<?php

namespace Tngnt\PBI\Model;

/**
 * A Power BI datasource connection details
 * https://docs.microsoft.com/ru-ru/rest/api/power-bi/pushdatasets/datasets_postdataset#datasourceconnectiondetails
 *
 * Class DatasourceConnectionDetails
 * @package Tngnt\PBI\Type
 */
class DatasourceConnectionDetails
{
    /**
     * @var string The connection database
     */
    public $database;

    /**
     * @var string The connection server
     */
    public $server;

    /**
     * @var string The connection url
     */
    public $url;
}