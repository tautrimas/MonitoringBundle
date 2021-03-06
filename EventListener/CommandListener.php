<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\MonitoringBundle\EventListener;

use ONGR\ElasticsearchBundle\ORM\Repository;
use ONGR\MonitoringBundle\Document\Event;
use Symfony\Component\Console\Event\ConsoleCommandEvent;

/**
 * Class to listen to console commands.
 */
class CommandListener extends BaseEventListener
{
    /**
     * {@inheritdoc}
     *
     * @param ConsoleCommandEvent $event ConsoleCommandEvent object.
     */
    protected function capture($event)
    {
        /** @var Event $document */
        $document = $this->getRepository()->createDocument();
        $document = $this->eventParser->getDocument($document, $event);
        $document->setStatus(Event::EVENT_STARTED);

        $document->setId($this->eventIdManager->getId($event->getCommand()));

        $this->manager->persist($document);
        $this->manager->commit();
    }
}
