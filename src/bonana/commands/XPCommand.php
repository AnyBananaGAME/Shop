<?php
namespace bonana\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;
use pocketmine\utils\TextFormat as TF;
use bonana\Main;
use function in_array;
use function is_numeric;
use function strtolower;

class XPCommand extends Command implements PluginOwned
{

    use PluginOwnedTrait;

    public function __construct(Main $plugin)
    {
        $this->owningPlugin = $plugin;
        parent::__construct("xp", "See how much xp a player has.", "/xp <player>");
        $this->setPermission("xp.command");
        $this->setDescription("See how much xp a player has.");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        if(!isset($args[0])) {
            $player = $this->getOwningPlugin()->getServer()->getPlayerExact($sender->getName());
            $username = $player->getName();
            $xp = $player->getXpManager()->getCurrentTotalXp();
            $sender->sendMessage("You have $xp xp");
            return false;
        }
        $player = $this->getOwningPlugin()->getServer()->getPlayerExact($args[0]);
        $username = $player->getName();
        $xp = $player->getXpManager()->getCurrentTotalXp();
        $sender->sendMessage("$username has $xp xp");
        return true;
    }


}