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

use pocketmine\block\VanillaBlocks as VB;
use pocketmine\item\VanillaItems as VI;
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

        $blockscat = VB::GRASS()->asItem();
        $blockscat->setCustomName("§r§l§7[ §r§cBlocks §r§l§7]§r");

        $armorcat = VI::DIAMOND_BOOTS();
        $armorcat->setCustomName("§r§l§7[ §r§cArmor §r§l§7]§r");

        $toolscat = VI::DIAMOND_PICKAXE();
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
                    $this->blockMenu($player);
                    break;
                case ItemIds::DIAMOND_BOOTS:
                    $player->sendMessage('You clicked DIAMOND_BOOTS');
                    $this->armorMenu($player);
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
    
    public function blockMenu(Player $player, ?callable $callable = null)/*: InvMenu*/{
        $blocksmenu = InvMenu::create(InvMenu::TYPE_DOUBLE_CHEST);
        $blocksmenu->setName(TF::RED . "WP " . TF::GREEN ."Shop");
        $inventory = $blocksmenu->getInventory();

        $grass = VB::GRASS()->asItem();
        $grass->setCustomName("§r§l§7[ §r§cGrass §r§l§7]§r");
            $dirt = VB::DIRT()->asItem();
            $dirt->setCustomName("§r§l§7[ §r§cDirt §r§l§7]§r");
                $stone = VB::STONE()->asItem();
                $stone->setCustomName("§r§l§7[ §r§cStone §r§l§7]§r");
                    $cobble = VB::COBBLESTONE()->asItem();
                    $cobble->setCustomName("§r§l§7[ §r§cCobblestone §r§l§7]§r");
                        $diorite = VB::DIORITE()->asItem();
                        $diorite->setCustomName("§r§l§7[ §r§cDiorite §r§l§7]§r");
        $granite = VB::GRANITE()->asItem();
        $granite->setCustomName("§r§l§7[ §r§cGranite §r§l§7]§r");
            $andesite = VB::ANDESITE()->asItem();
            $andesite->setCustomName("§r§l§7[ §r§cAndesite §r§l§7]§r");
                $quartz = VB::QUARTZ()->asItem();
                $quartz->setCustomName("§r§l§7[ §r§cQuartz §r§l§7]§r");
                    $quarts_pillar = VB::QUARTZ_PILLAR()->asItem();
                    $quarts_pillar->setCustomName("§r§l§7[ §r§cQuartz Pillar §r§l§7]§r");
                        $chiseled_quartz = VB::CHISELED_QUARTZ()->asItem();
                        $chiseled_quartz->setCustomName("§r§l§7[ §r§cChiseled Quartz §r§l§7]§r");
        $smooth_quartz = VB::SMOOTH_QUARTZ()->asItem();
        $smooth_quartz->setCustomName("§r§l§7[ §r§cSmooth Quartz §r§l§7]§r");
            $gravel = VB::GRAVEL()->asItem();
            $gravel->setCustomName("§r§l§7[ §r§cGravel §r§l§7]§r");
                $sand = VB::SAND()->asItem();
                $sand->setCustomName("§r§l§7[ §r§cSand §r§l§7]§r");
        

        $inventory->setItem(0, $grass);
        $inventory->setItem(1, $dirt);
        $inventory->setItem(2, $stone);
        $inventory->setItem(3, $cobble);
        $inventory->setItem(4, $diorite);
        $inventory->setItem(5, $granite);
        $inventory->setItem(6, $andesite);
        $inventory->setItem(7, $gravel);
        $inventory->setItem(8, $sand);



        $inventory->setItem(9, $quartz);
        $inventory->setItem(10, $quarts_pillar);
        $inventory->setItem(11, $chiseled_quartz);
        $inventory->setItem(12, $smooth_quartz);

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
    public function armorMenu(Player $player, ?callable $callable = null){
        
        $armormenu = InvMenu::create(InvMenu::TYPE_DOUBLE_CHEST);
        $armormenu->setName(TF::RED . "WP " . TF::GREEN ."Shop");
        $inventory = $armormenu->getInventory();

        
        $leather_helmet = VI::LEATHER_CAP();
        $leather_helmet->setCustomName("§r§l§7[§r§c Leather Helmet §r§l§7]§r");
        $leather_chestplace = VI::LEATHER_TUNIC();
        $leather_chestplace->setCustomName("§r§l§7[§r§c Leather Chestplate §r§l§7]§r");
        $leather_leggings = VI::LEATHER_PANTS();
        $leather_leggings->setCustomName("§r§l§7[§r§c Leather Leggings §r§l§7]§r");
        $leather_boots = VI::LEATHER_BOOTS();
        $leather_boots->setCustomName("§r§l§7[§r§c Leather Boots §r§l§7]§r");

        $chain_helmet = VI::CHAINMAIL_HELMET();
        $chain_helmet->setCustomName("§r§l§7[ §r§cChainmail Helmet §r§l§7]§r");
        $chain_chestplace = VI::CHAINMAIL_CHESTPLATE();
        $chain_chestplace->setCustomName("§r§l§7[ §r§cChainmail Chestplate §r§l§7]§r");
        $chain_leggings = VI::CHAINMAIL_LEGGINGS();
        $chain_leggings->setCustomName("§r§l§7[ §r§cChainmail Leggings §r§l§7]§r");
        $chain_boots = VI::CHAINMAIL_BOOTS();
        $chain_boots->setCustomName("§r§l§7[ §r§cChainmail Boots §r§l§7]§r");

        $gold_helmet = VI::GOLDEN_HELMET();
        $gold_helmet->setCustomName("§r§l§7[§r§c Golden Helmet §r§l§7]§r");
        $gold_chestplace = VI::GOLDEN_CHESTPLATE();
        $gold_chestplace->setCustomName("§r§l§7[§r§c Golden Chestplate §r§l§7]§r");
        $gold_leggings = VI::GOLDEN_LEGGINGS();
        $gold_leggings->setCustomName("§r§l§7[§r§c Golden Leggings §r§l§7]§r");
        $gold_boots = VI::GOLDEN_BOOTS();
        $gold_boots->setCustomName("§r§l§7[§r§c Golden Boots §r§l§7]§r");

        $iron_helmet = VI::IRON_HELMET();
        $iron_helmet->setCustomName("§r§l§7[§r§c Iron Helmet §r§l§7]§r");
        $iron_chestplace = VI::IRON_CHESTPLATE();
        $iron_chestplace->setCustomName("§r§l§7[§r§c Iron Chestplate §r§l§7]§r");
        $iron_leggings = VI::IRON_LEGGINGS();
        $iron_leggings->setCustomName("§r§l§7[§r§c Iron Leggings §r§l§7]§r");
        $iron_boots = VI::IRON_BOOTS();
        $iron_boots->setCustomName("§r§l§7[§r§c Iron Boots §r§l§7]§r");

        $dia_helmet = VI::DIAMOND_HELMET();
        $dia_helmet->setCustomName("§r§l§7[§r§c Diamond Helmet §r§l§7]§r");
        $dia_chestplace = VI::DIAMOND_CHESTPLATE();
        $dia_chestplace->setCustomName("§r§l§7[§r§c Diamond Chestplate §r§l§7]§r");
        $dia_leggings = VI::DIAMOND_LEGGINGS();
        $dia_leggings->setCustomName("§r§l§7[§r§c Diamond Leggings §r§l§7]§r");
        $dia_boots = VI::DIAMOND_BOOTS();
        $dia_boots->setCustomName("§r§l§7[§r§c Diamond Boots §r§l§7]§r");

        $inventory->setItem(0, $leather_helmet);
        $inventory->setItem(9, $leather_chestplace);
        $inventory->setItem(18, $leather_leggings);
        $inventory->setItem(27, $leather_boots);

        $inventory->setItem(1, $chain_helmet);
        $inventory->setItem(10, $chain_chestplace);
        $inventory->setItem(19, $chain_leggings);
        $inventory->setItem(28, $chain_boots);

        $inventory->setItem(2, $iron_helmet);
        $inventory->setItem(11, $iron_chestplace);
        $inventory->setItem(20, $iron_leggings);
        $inventory->setItem(29, $iron_boots);

        $inventory->setItem(3, $gold_helmet);
        $inventory->setItem(12, $gold_chestplace);
        $inventory->setItem(21, $gold_leggings);
        $inventory->setItem(30, $gold_boots);

        $inventory->setItem(4, $dia_helmet);
        $inventory->setItem(13, $dia_chestplace);
        $inventory->setItem(22, $dia_leggings);
        $inventory->setItem(31, $dia_boots);



        $armormenu->setListener(function (InvMenuTransaction $tr)use($callable): InvMenuTransactionResult{
            $player = $tr->getPlayer();
            $item = $tr->getItemClicked();
            switch($item->getId()){
                case ItemIds::CHAINMAIL_HELMET:
                    $player->sendMessage('You cant buy yet');
                    break; 
            }
            if($callable !== null){
                return $callable($tr);
            }
            return $tr->discard();
        });
        return $armormenu->send($player);
    }

}