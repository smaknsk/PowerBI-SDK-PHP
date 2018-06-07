<?php

namespace Tngnt\PBI\Model;

class Dataset
{

    /**
     * @var boolean Dataset requires effective identity
     */
    public $IsEffectiveIdentityRequired;

    /**
     * @var boolean Dataset requires roles
     */
    public $IsEffectiveIdentityRolesRequired;

    /**
     * @var boolean Dataset requires onprem gateway
     */
    public $IsOnPremGatewayRequired;

    /**
     * @var boolean Can this dataset be refreshed
     */
    public $IsRefreshable;

    /**
     * @var boolean Whether dataset allows adding new rows
     */
    public $addRowsAPIEnabled;

    /**
     * @var string The dataset owner
     */
    public $configuredBy;

    /**
     * @var Datasource[] The datasources associated with this dataset, only relevant to Post Dataset API
     */
    public $datasources = [];

    /**
     * @var DatasetMode The dataset mode or type, only relevant to Post Dataset API
     */
    public $defaultMode;

    /**
     * @var string The dataset default data retention policy, only relevant to Post Dataset API
     */
    public $defaultRetentionPolicy;

    /**
     * @var string The dataset id
     */
    public $id;

    /**
     * @var string The dataset name
     */
    public $name;

    /**
     * @var Relationship The dataset relationships, only relevant to Post Dataset API
     */
    public $relationships = [];

    /**
     * @var Table[] The dataset tables, only relevant to Post Dataset API
     */
    public $tables = [];

    /**
     * @var string The dataset web url
     */
    public $webUrl;

    /**
     * Dataset constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getTables()
    {
        return $this->tables;
    }

    /**
     * @param Table $table
     * @return $this
     */
    public function addTable(Table $table)
    {
        $this->tables[] = $table;

        return $this;
    }

    public function toArray()
    {
        $data = array_filter((array) $this);

        if (!isset($data['tables'])) {
            $data['tables'] = [];
        }

        return $data;
    }
}
