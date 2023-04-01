<?php
declare(strict_types=1);

namespace bonana;

use pocketmine\plugin\PluginBase;
use muqsit\invmenu\InvMenuHandler;
use bonana\commands\ShopCommand;
use bonana\commands\GiveXPCommand;
use bonana\commands\XPCommand;

class Main extends PluginBase {
    private static self $instance;

    public static function getInstance(): Main {
        return self::$instance;
    }

    public function onLoad(): void {
        self::$instance = $this;
    }

    public function onEnable(): void {
	if (!InvMenuHandler::isRegistered()) {
            InvMenuHandler::register($this);
        }

        $this->getServer()->getCommandMap()->registerAll("shop", [ new ShopCommand($this), ]);

	$this->getServer()->getCommandMap()->registerAll("xp", [ new XPCommand($this), new GiveXPCommand($this), ]);

        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
    }
}
