<?php

namespace Tngnt\PBI\Model;

/**
 * A Power BI datasource
 * https://docs.microsoft.com/ru-ru/rest/api/power-bi/pushdatasets/datasets_postdataset#datasource
 *
 * Class Datasource
 * @package Tngnt\PBI\Type
 */
class Datasource
{
    /**
     * @var string The datasource name, available only for direct query.
     */
    public $name;

    /**
     * @var string The bound gateway id, empty when not bound to a gateway
     */
    public $gatewayId;

    /**
     * @var string The datasource type
     */
    public $datasourceType;

    /**
     * @var string The bound datasource id, empty when not bound to a gateway
     */
    public $datasourceId;

    /**
     * @var string The datasource connection string, available only for direct query.
     */
    public $connectionString;

    /**
     * @var DatasourceConnectionDetails The datasource connection details
     */
    public $connectionDetails;
}
