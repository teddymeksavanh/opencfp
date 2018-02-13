<?php

declare(strict_types=1);

/**
 * Copyright (c) 2013-2018 OpenCFP.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/opencfp/opencfp
 */

namespace OpenCFP\Http\View;

class TalkHelper
{
    /**
     * @var string[]
     */
    private $categories;

    /**
     * @var string[]
     */
    private $levels;

    /**
     * @var string[]
     */
    private $types;

    /**
     * @param $categories
     * @param $levels
     * @param $types
     */
    public function __construct($categories, $levels, $types)
    {
        $this->categories = $categories;
        $this->levels = $levels;
        $this->types = $types;
    }

    public function getTalkCategories()
    {
        $categories = $this->categories;

        if ($categories === null) {
            $categories = [
                'api' => 'APIs (REST, SOAP, etc.)',
                'continuousdelivery' => 'Continuous Delivery',
                'database' => 'Database',
                'development' => 'Development',
                'devops' => 'Devops',
                'framework' => 'Framework',
                'ibmi' => 'IBMi',
                'javascript' => 'JavaScript',
                'security' => 'Security',
                'testing' => 'Testing',
                'uiux' => 'UI/UX',
                'other' => 'Other',
            ];
        }

        return $categories;
    }

    /**
     * @param $category
     *
     * @return mixed
     */
    public function getCategoryDisplayName($category)
    {
        if (isset($this->categories[$category])) {
            return $this->categories[$category];
        }

        return $category;
    }

    public function getTalkTypes()
    {
        $types = $this->types;

        if ($types === null) {
            $types = [
                'regular' => 'Regular',
                'tutorial' => 'Tutorial',
            ];
        }

        return $types;
    }

    /**
     * @param $type
     *
     * @return mixed
     */
    public function getTypeDisplayName($type)
    {
        if (isset($this->types[$type])) {
            return $this->types[$type];
        }

        return $type;
    }

    public function getTalkLevels()
    {
        $levels = $this->levels;

        if ($levels === null) {
            $levels = [
                'entry' => 'Entry level',
                'mid' => 'Mid-level',
                'advanced' => 'Advanced',
            ];
        }

        return $levels;
    }

    /**
     * @param $level
     *
     * @return mixed
     */
    public function getLevelDisplayName($level)
    {
        if (isset($this->levels[$level])) {
            return $this->levels[$level];
        }

        return $level;
    }
}
