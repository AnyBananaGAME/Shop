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

class GiveXPCommand extends Command implements PluginOwned
{

    use PluginOwnedTrait;

    public function __construct(Main $plugin)
    {
        $this->owningPlugin = $plugin;
        parent::__construct("givexp", "Give xp to a player", "/givexp <player> <amount>");
        $this->setPermission("xp.command.give");
        $this->setDescription("Give xp to a player");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        if(!isset($args[0])) {
            $sender->sendMessage(TF::RED . "You must provide some arguments!" . TF::EOL . "Usage: /givexp <player> <amount>");
            return true;
        } elseif(!$this->getOwningPlugin()->getServer()->getPlayerExact($args[0])) {
            $sender->sendMessage(TF::RED . "You must provide a valid player!");
            return true;
        } elseif(!isset($args[1]) || !is_numeric($args[1])) {
            $sender->sendMessage(TF::RED . "You must provide a valid amount!");
            return true;
        }
        $player = $this->getOwningPlugin()->getServer()->getPlayerExact($args[0]);
        $amount = (int)$args[1];
        $player->getXpManager()->addXp($amount, false);

        // $player->getXpManager()->getCurrentTotalXp()
        $player->sendMessage("You have been given $amount xp");
        $sender->sendMessage("You have given $args[0] $amount xp");
        return false;
    }


}
