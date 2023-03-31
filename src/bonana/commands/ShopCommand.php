<?php

namespace bonana\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;
use pocketmine\utils\TextFormat as TF;

use muqsit\invmenu\InvMenu;
use muqsit\invmenu\InvMenuHandler;
use muqsit\invmenu\transaction\InvMenuTransaction;
use muqsit\invmenu\transaction\InvMenuTransactionResult;

use pocketmine\block\VanillaBlocks as VB;
use pocketmine\block\utils\DyeColor;
use pocketmine\item\VanillaItems as VI;
use pocketmine\item\ItemFactory;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\item\ItemIds;
use bonana\Main;

class ShopCommand extends Command implements PluginOwned {

    use PluginOwnedTrait;
	private array $config;
    private $iitem;
    private $imenu;

	public function __construct(Main $plugin) {
		$this->owningPlugin = $plugin;
		parent::__construct("shop", "Open Shop", "/shop");
		$this->setPermission("shop.command");
		$this->setDescription("Open Shop!");
        $this->config = $plugin->getConfig()->getAll();
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



        $dia_sword = VI::DIAMOND_SWORD();
        $dia_sword->setCustomName("§r§l§7[§r§c Diamond Sword §r§l§7]§r");
        $dia_axe = VI::DIAMOND_AXE();
        $dia_axe->setCustomName("§r§l§7[§r§c Diamond Axe §r§l§7]§r");
        $dia_pickaxe = VI::DIAMOND_PICKAXE();
        $dia_pickaxe->setCustomName("§r§l§7[§r§c Diamond Pickaxe §r§l§7]§r");


        $iron_sword = VI::IRON_SWORD();
        $iron_sword->setCustomName("§r§l§7[§r§c Iron Sword §r§l§7]§r");
        $iron_axe = VI::IRON_AXE();
        $iron_axe->setCustomName("§r§l§7[§r§c Iron Axe §r§l§7]§r");
        $iron_pickaxe = VI::IRON_PICKAXE();
        $iron_pickaxe->setCustomName("§r§l§7[§r§c Iron Pickaxe §r§l§7]§r");


        $gold_sword = VI::GOLDEN_SWORD();
        $gold_sword->setCustomName("§r§l§7[§r§c Golden Sword §r§l§7]§r");
        $gold_axe = VI::GOLDEN_AXE();
        $gold_axe->setCustomName("§r§l§7[§r§c Golden Axe §r§l§7]§r");
        $gold_pickaxe = VI::GOLDEN_PICKAXE();
        $gold_pickaxe->setCustomName("§r§l§7[§r§c Golden Pickaxe §r§l§7]§r");


        $stone_sword = VI::STONE_SWORD();
        $stone_sword->setCustomName("§r§l§7[§r§c Stone Sword §r§l§7]§r");
        $stone_axe = VI::STONE_AXE();
        $stone_axe->setCustomName("§r§l§7[§r§c Stone Axe §r§l§7]§r");
        $stone_pickaxe = VI::STONE_PICKAXE();
        $stone_pickaxe->setCustomName("§r§l§7[§r§c Stone Pickaxe §r§l§7]§r");

        $glass = VB::STAINED_GLASS_PANE()->setColor(DyeColor::GRAY())->asItem();
        $glass->setCustomName(" ");


        $inventory->setItem(9, $leather_helmet);
        $inventory->setItem(18, $leather_chestplace);
        $inventory->setItem(27, $leather_leggings);
        $inventory->setItem(36, $leather_boots);

        $inventory->setItem(10, $chain_helmet);
        $inventory->setItem(19, $chain_chestplace);
        $inventory->setItem(28, $chain_leggings);
        $inventory->setItem(37, $chain_boots);

        $inventory->setItem(11, $iron_helmet);
        $inventory->setItem(20, $iron_chestplace);
        $inventory->setItem(29, $iron_leggings);
        $inventory->setItem(38, $iron_boots);

        $inventory->setItem(12, $gold_helmet);
        $inventory->setItem(21, $gold_chestplace);
        $inventory->setItem(30, $gold_leggings);
        $inventory->setItem(39, $gold_boots);

        $inventory->setItem(13, $dia_helmet);
        $inventory->setItem(22, $dia_chestplace);
        $inventory->setItem(31, $dia_leggings);
        $inventory->setItem(40, $dia_boots);


        $inventory->setItem(15, $dia_pickaxe);
        $inventory->setItem(16, $dia_axe);
        $inventory->setItem(17, $dia_sword);

        $inventory->setItem(24, $iron_pickaxe);
        $inventory->setItem(25, $iron_axe);
        $inventory->setItem(26, $iron_sword);

        $inventory->setItem(33, $gold_pickaxe);
        $inventory->setItem(34, $gold_axe);
        $inventory->setItem(35, $gold_sword);

        $inventory->setItem(42, $stone_pickaxe);
        $inventory->setItem(43, $stone_axe);
        $inventory->setItem(44, $stone_sword);

        for($x = 0; $x < 9; $x++) {
            $inventory->setItem($x, $glass);
        }
        for($x = 45; $x < 54; $x++) {
            $inventory->setItem($x, $glass);
        }
        $inventory->setItem(5, $glass);
        $inventory->setItem(14, $glass);
        $inventory->setItem(23, $glass);
        $inventory->setItem(32, $glass);
        $inventory->setItem(41, $glass);

        $armormenu->setListener(function (InvMenuTransaction $tr)use($callable): InvMenuTransactionResult{
            $player = $tr->getPlayer();
            $item = $tr->getItemClicked();
            if($item->getId() == 160) return;

            $this->openPurchaseMenu($item, $player);
            $player->sendMessage("id: ".$item->getId());

            if($callable !== null){
                return $callable($tr);
            }
            return $tr->discard();
        });
        return $armormenu->send($player);
    }


    public function openPurchaseMenu($item, Player $player, ?callable $callable = null){
        $purchasemenu = InvMenu::create(InvMenu::TYPE_DOUBLE_CHEST);
        $purchasemenu->setName(TF::RED . "WP " . TF::GREEN ."Shop");
        $inventory = $purchasemenu->getInventory();


        
        $inventory->setItem(22, $item);
        $NMN = $item->getName();
        $id = $item->getId();   
        // $cost = $this->config["cost"][$id];
        $cost = 100;
        $buy1 = VB::STAINED_GLASS()->setColor(DyeColor::GREEN())->asItem();
        $buy1->setCustomName("§7Purchase §c1x §a$NMN\n\n§7Buy §c1x §7 for §c$cost");


        $inventory->setItem(11, $buy1);
        $pitem = $item;
        $this->iitem = $pitem;
        $this->imenu = $purchasemenu;

        $purchasemenu->setListener(function (InvMenuTransaction $tr)use($callable): InvMenuTransactionResult {
            $player = $tr->getPlayer();
            $item = $tr->getItemClicked();
            $player->sendMessage($item->getId());
            
            switch($item->getId()){
                case 241:
                    // $this->confirmPurchase($this->iitem, $player, 1, $this->imenu);
                    $player->sendMessage('You clicked \nID' . $item->getId() . "\nMETA: ". $item->getMeta());
                    break; 
            }


            if($callable !== null){
                return $callable($tr);
            }
            return $tr->discard();
        });
        return $purchasemenu->send($player);

    }

    public function confirmPurchase($item, Player $player, $amount, $menu){
        $id = $item->getId();   
        $cost = $this->config["cost"][$id];
        $xp = $player->getXpManager()->getCurrentTotalXp();
        $totalCost = $cost*$amount;
        $IM = $item->getName();
        $playerInventory = $player->getInventory();



        $playerX = $player->getPosition()->getX();
        $playerY = $player->getPosition()->getY();
        $playerZ = $player->getPosition()->getZ();

        if($xp < $totalCost){
            return $player->sendMessage("§7§l[§cFAIL§7] §r§7You can not afford x§c$amount §a| §c$IM");
        } else {
            $ii = ItemFactory::getInstance()->get($id);
            $vector3Pos = new Vector3($playerX, $playerY, $playerZ);
            if($playerInventory->canAddItem($ii)) {
                $playerInventory->addItem($ii);
                $player->getXpManager()->addXp(-$totalCost, false);
                $player->sendMessage("§7§l[§aSUCCESS§7] §r§7You have purchased x§c$amount §a| §c$IM");
            } else {
                InvMenuHandler::getPlayerManager()->get($player)->removeCurrentMenu();
                $player->sendMessage(TF::RED . "Your inventory is full!");
            }
           }


    }

}