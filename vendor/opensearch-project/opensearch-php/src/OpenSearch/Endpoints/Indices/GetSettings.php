<?php

declare(strict_types=1);

/**
 * Copyright OpenSearch Contributors
 * SPDX-License-Identifier: Apache-2.0
 *
 * Elasticsearch PHP client
 *
 * @link      https://github.com/elastic/elasticsearch-php/
 * @copyright Copyright (c) Elasticsearch B.V (https://www.elastic.co)
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license   https://www.gnu.org/licenses/lgpl-2.1.html GNU Lesser General Public License, Version 2.1
 *
 * Licensed to Elasticsearch B.V under one or more agreements.
 * Elasticsearch B.V licenses this file to you under the Apache 2.0 License or
 * the GNU Lesser General Public License, Version 2.1, at your option.
 * See the LICENSE file in the project root for more information.
 */

namespace OpenSearch\Endpoints\Indices;

use OpenSearch\Endpoints\AbstractEndpoint;

class GetSettings extends AbstractEndpoint
{
    protected $name;

    public function getURI(): string
    {
        $index = $this->index ?? null;
        $name = $this->name ?? null;

        if (isset($index) && isset($name)) {
            return "/$index/_settings/$name";
        }
        if (isset($index)) {
            return "/$index/_settings";
        }
        if (isset($name)) {
            return "/_settings/$name";
        }
        return "/_settings";
    }

    public function getParamWhitelist(): array
    {
        return [
            'master_timeout',
            'ignore_unavailable',
            'allow_no_indices',
            'expand_wildcards',
            'flat_settings',
            'local',
            'include_defaults',
            'cluster_manager_timeout'
        ];
    }

    public function getMethod(): string
    {
        return 'GET';
    }

    public function setName($name): GetSettings
    {
        if (isset($name) !== true) {
            return $this;
        }
        if (is_array($name) === true) {
            $name = implode(",", $name);
        }
        $this->name = $name;

        return $this;
    }
    protected function getParamDeprecation(): array
    {
        return ['master_timeout' => 'cluster_manager_timeout'];
    }
}
