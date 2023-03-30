<?php
declare(strict_types=1);

namespace bonana;

use pocketmine\event\Listener;
use pocketmine\event\block\BlockBreakEvent;
use muqsit\invmenu\InvMenuHandler;

class EventListener implements Listener {
	private Main $plugin;

    public function __construct(Main $plugin) {
		$this->plugin = $plugin;
	}

    // THIS IS FOR TESTING ONLY
    // THIS IS FOR TESTING ONLY
    // THIS IS FOR TESTING ONLY
    // THIS IS FOR TESTING ONLY
    // THIS IS FOR TESTING ONLY
    // THIS IS FOR TESTING ONLY

	public function onBreak(BlockBreakEvent $event): void {
		$player = $event->getPlayer();
        $server = $event->getPlayer()->getServer();
        $this->plugin->getServer()->getCommandMap()->dispatch($player, "shop");
    }


}