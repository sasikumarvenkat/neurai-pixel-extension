<?php

namespace Henhed\Piwik\Observer;

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


use Magento\Framework\Event\ObserverInterface;

/**
 * Observer for `piwik_track_page_view_after'
 *
 */
class AfterTrackPageViewObserver implements ObserverInterface
{

    /**
     * Piwik data helper
     *
     * @var \Henhed\Piwik\Helper\Data
     */
    protected $_dataHelper;

    /**
     * Constructor
     *
     * @param \Henhed\Piwik\Helper\Data $dataHelper
     */
    public function __construct(\Henhed\Piwik\Helper\Data $dataHelper)
    {
        $this->_dataHelper = $dataHelper;
    }

    /**
     * Push additional actions to tracker after `trackPageView' is added
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return \Henhed\Piwik\Observer\AfterTrackPageViewObserver
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $tracker = $observer->getEvent()->getTracker();
        /* @var $tracker \Henhed\Piwik\Model\Tracker */
        if ($this->_dataHelper->isContentTrackingEnabled()) {
            $tracker->trackVisibleContentImpressions();
            $tracker->trackContentInteraction();
        }
        return $this;
    }


}

