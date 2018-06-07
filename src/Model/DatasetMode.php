<?php

namespace Tngnt\PBI\Model;

/**
 * The dataset mode or type, only relevant to Post Dataset API
 *
 * Class DatasetMode
 * @package Tngnt\PBI\Type
 */
class DatasetMode
{
    const AsAzure = 'AsAzure';
    const AsOnPrem = 'AsOnPrem';
    const Push = 'Push';
    const PushStreaming = 'PushStreaming';
    const Streaming = 'Streaming';
}
