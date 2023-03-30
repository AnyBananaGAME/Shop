<?php

namespace bonana\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;
use pocketmine\utils\TextFormat as TF;

use muqsit\invmenu\InvMenu;
use muqsit\invmenu\transaction\InvMenuTransaction;
use muqsit\invmenu\transaction\InvMenuTransactionResult;

use pocketmine\block\VanillaBlocks;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;
use pocketmine\item\ItemIds;
use bonana\Main;

class ShopCommand extends Command implements PluginOwned {

    use PluginOwnedTrait;

	public function __construct(Main $plugin) {
		$this->owningPlugin = $plugin;
		parent::__construct("shop", "Open Shop", "/shop");
		$this->setPermission("shop.command");
		$this->setDescription("Open Shop!");
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args, ?callable $callable = null): void {
        $this->mainMenu($sender);
    }


    public function mainMenu(Player $player, ?callable $callable = null){
        $menu = InvMenu::create(InvMenu::TYPE_CHEST);
        $menu->setName(TF::RED . "WP " . TF::GREEN ."Shop");
        $inventory = $menu->getInventory();

        $blockscat = VanillaBlocks::GRASS()->asItem();
        $blockscat->setCustomName("§r§l§7[ §r§cBlocks §r§l§7]§r");

        $armorcat = VanillaItems::DIAMOND_BOOTS();
        $armorcat->setCustomName("§r§l§7[ §r§cArmor §r§l§7]§r");

        $toolscat = VanillaItems::DIAMOND_PICKAXE();
        $toolscat->setCustomName("§r§l§7[ §r§cTools §r§l§7]§r");

        $inventory->setItem(0, $blockscat);
        $inventory->setItem(1, $armorcat);
        $inventory->setItem(2, $toolscat);

        $menu->setListener(function (InvMenuTransaction $tr)use($callable): InvMenuTransactionResult{
            $player = $tr->getPlayer();
            $item = $tr->getItemClicked();

            switch($item->getId()){
                case ItemIds::GRASS:
                    $player->sendMessage('You clicked GRASS');
                    $this->armorMenu($player);
                    break;
                case ItemIds::DIAMOND_BOOTS:
                    $player->sendMessage('You clicked DIAMOND_BOOTS');
                    $armormenu = InvMenu::create(InvMenu::TYPE_DOUBLE_CHEST);
                    $armormenu->setName(TF::RED . "WP " . TF::GREEN ."Shop");
                    $armormenu->send($player);
                    break;  
                case ItemIds::DIAMOND_PICKAXE:
                    $player->sendMessage('You clicked DIAMOND_PICKAXE');
                    $toolsmenu = InvMenu::create(InvMenu::TYPE_DOUBLE_CHEST);
                    $toolsmenu->setName(TF::RED . "WP " . TF::GREEN ."Shop");

                    $toolsmenu->send($player);
                    break;
            }


            if($callable !== null){
                return $callable($tr);
            }
            return $tr->discard();
        });
        return $menu->send($player);

    }

    public function armorMenu(Player $player, ?callable $callable = null)/*: InvMenu*/{
        $blocksmenu = InvMenu::create(InvMenu::TYPE_DOUBLE_CHEST);
        $blocksmenu->setName(TF::RED . "WP " . TF::GREEN ."Shop");
        $inventory = $blocksmenu->getInventory();

        $grass = VanillaBlocks::GRASS()->asItem();
        $grass->setCustomName("§r§l§7[ §r§cGrass §r§l§7]§r");
            $dirt = VanillaBlocks::DIRT()->asItem();
            $dirt->setCustomName("§r§l§7[ §r§cDirt §r§l§7]§r");
                $stone = VanillaBlocks::STONE()->asItem();
                $stone->setCustomName("§r§l§7[ §r§cStone §r§l§7]§r");
                    $cobble = VanillaBlocks::COBBLESTONE()->asItem();
                    $cobble->setCustomName("§r§l§7[ §r§cCobblestone §r§l§7]§r");

        $inventory->setItem(0, $grass);
        $inventory->setItem(1, $dirt);
        $inventory->setItem(2, $stone);
        $inventory->setItem(3, $cobble);

        $blocksmenu->setListener(function (InvMenuTransaction $tr)use($callable): InvMenuTransactionResult{
            $player = $tr->getPlayer();
            $item = $tr->getItemClicked();
            switch($item->getId()){
                case ItemIds::GRASS:
                    $player->sendMessage('You clicked GRASS 111');
                    break; 
            }
            if($callable !== null){
                return $callable($tr);
            }
            return $tr->discard();
        });
        return $blocksmenu->send($player);
    }


}