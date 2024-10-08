<?php

declare(strict_types=1);
/**
 * @copyright Copyright (c) 2020 Joas Schilling <coding@schilljs.com>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\Maps\Listener;

use OCA\DAV\Events\CardDeletedEvent;
use OCA\Maps\Service\AddressService;
use OCP\EventDispatcher\Event;
use OCP\EventDispatcher\IEventListener;

/** @template-implements IEventListener<CardDeletedEvent> */
class CardDeletedListener implements IEventListener {

	/** @var AddressService */
	private $addressService;

	public function __construct(
		AddressService $addressService,
	) {
		$this->addressService = $addressService;
	}

	public function handle(Event $event): void {
		if (!($event instanceof CardDeletedEvent)) {
			// Unrelated
			return;
		}
		$cData = $event->getCardData();
		$cUri = $cData['uri'];
		$this->addressService->deleteDBContactAddresses($cUri);
	}
}
