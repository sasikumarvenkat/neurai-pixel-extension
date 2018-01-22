<?php
/**
 * Copyright 2016-2017 Henrik Hedelund
 *
 * This file is part of Henhed_Piwik.
 *
 * Henhed_Piwik is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Henhed_Piwik is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with Henhed_Piwik.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Henhed\Piwik\Model;


class Tracker
{

    /**
     * Action items
     *
     * @var \Henhed\Piwik\Model\Tracker\Action[] $_actions
     */
    protected $_actions = [];

    /**
     * Tracker action factory instance
     *
     * @var \Henhed\Piwik\Model\Tracker\ActionFactory $_actionFactory
     */
    protected $_actionFactory;

    /**
     * Constructor
     *
     * @param \Henhed\Piwik\Model\Tracker\ActionFactory $actionFactory
     */
    public function __construct(
        \Henhed\Piwik\Model\Tracker\ActionFactory $actionFactory
    ) {
        $this->_actionFactory = $actionFactory;
    }

    /**
     * Push an action to this tracker
     *
     * @param \Henhed\Piwik\Model\Tracker\Action $action
     * @return \Henhed\Piwik\Model\Tracker
     */
    public function push(Tracker\Action $action)
    {
        $this->_actions[] = $action;
        return $this;
    }

    /**
     * Get all actions in this tracker
     *
     * @return \Henhed\Piwik\Model\Tracker\Action[]
     */
    public function getActions()
    {
        return $this->_actions;
    }

    /**
     * Get an array representation of this tracker
     *
     * @return array
     */
    public function toArray()
    {
        $array = [];
        foreach ($this->getActions() as $action) {
            $array[] = $action->toArray();
        }
        return $array;
    }

    /**
     * Magic action push function
     *
     * @param string $name
     * @param array $arguments
     * @return \Henhed\Piwik\Model\Tracker
     */
    public function __call($name, $arguments)
    {
        return $this->push($this->_actionFactory->create([
            'name' => $name,
            'args' => $arguments
        ]));
    }
}
