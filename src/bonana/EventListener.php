<?php
declare(strict_types=1);

namespace bonana;

use pocketmine\event\Listener;
use pocketmine\event\block\BlockBreakEvent;
use muqsit\invmenu\InvMenuHandler;

class EventListener extends Listener {

    public function __construct(Main $IT) {
		$this->IT = $IT;
	}
	public function onBreak(BlockBreakEvent $event): void {
		$player = $event->getPlayer();


    }


}