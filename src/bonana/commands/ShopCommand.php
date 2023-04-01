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
        $blockscat->setCustomName("§r§l§7[§r§c Blocks §r§l§7]§r");

        $armorcat = VI::DIAMOND_BOOTS();
        $armorcat->setCustomName("§r§l§7[§r§c Armor §r§l§7]§r");

        $foodcat = VI::STEAK();
        $foodcat->setCustomName("§r§l§7[§r§c Food §r§l§7]§r");


        $inventory->setItem(0, $blockscat);
        $inventory->setItem(1, $armorcat);
        $inventory->setItem(2, $foodcat);

        $menu->setListener(function (InvMenuTransaction $tr)use($callable): InvMenuTransactionResult{
            $player = $tr->getPlayer();
            $item = $tr->getItemClicked();

            switch($item->getId()){
                case ItemIds::GRASS:
                    $this->blockMenu($player);
                    break;
                case ItemIds::DIAMOND_BOOTS:
                    $this->armorMenu($player);
                    break;  
                case ItemIds::STEAK:
                    $this->foodMenu($player);
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

        $back = VI::ARROW();
        $back->setCustomName("§l§c<- Back");
        $inventory->setItem(49, $back);

        $blocksmenu->setListener(function (InvMenuTransaction $tr)use($callable): InvMenuTransactionResult{
            $player = $tr->getPlayer();
            $item = $tr->getItemClicked();
            if($item->getId() == 262){
                $this->mainMenu($player);
            } else {
                $this->openPurchaseMenu($item, $player);
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

        $back = VI::ARROW();
        $back->setCustomName("§l§c<- Back");



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
        $inventory->setItem(50, $back);

        $armormenu->setListener(function (InvMenuTransaction $tr)use($callable): InvMenuTransactionResult{
            $player = $tr->getPlayer();
            $item = $tr->getItemClicked();
            if($item->getId() == 160){
                return $tr->discard();
            }
            if($item->getId() == 262){
                $this->mainMenu($player);
            } else {
                $this->openPurchaseMenu($item, $player);
            }
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
        $cost = $this->config["cost"][$id];
        // $cost = 100;
        $buy1 = VB::STAINED_GLASS()->setColor(DyeColor::GREEN())->asItem();
        $buy1->setCustomName("§7Purchase §cx1 §a$NMN\n\n§7Buy §cx1 §7 for §c$cost");

        $stack = $item->getMaxStackSize();

        $stackcost = $stack*$cost;
        $buystack = VB::STAINED_GLASS()->setColor(DyeColor::ORANGE())->asItem();
        $buystack->setCustomName("§7Purchase §cx$stack  §a$NMN\n\n§7Buy §cx$stack §7 for §c$stackcost");

        $invcost = $stack*$cost;
        $buyinv = VB::STAINED_GLASS()->setColor(DyeColor::RED())->asItem();
        $buyinv->setCustomName("§7Purchase §cx$stack  §a$NMN\n\n§7Buy §cx$stack §7 for §c$stackcost");


        $back = VI::ARROW();
        $back->setCustomName("§l§c<- Back");


        $inventory->setItem(11, $buy1);
        $inventory->setItem(20, $buystack);

        $inventory->setItem(40, $back);

        $pitem = $item;
        $this->iitem = $pitem;
        $this->imenu = $purchasemenu;

        $purchasemenu->setListener(function (InvMenuTransaction $tr)use($callable): InvMenuTransactionResult {
            $player = $tr->getPlayer();
            $item = $tr->getItemClicked();
            
            $stack = $this->iitem->getMaxStackSize();

            if($item->getId() == 241){
                if($item->getMeta() == 13){
                    $this->confirmPurchase($this->iitem, $player, 1, $this->imenu);
                }
                if($item->getMeta() == 1){
                    $this->confirmPurchase($this->iitem, $player, $stack, $this->imenu);
                }
            }
            if($item->getId() == 262){
                $this->mainMenu($player);

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
        $contents = $playerInventory->getContents();


        $playerX = $player->getPosition()->getX();
        $playerY = $player->getPosition()->getY();
        $playerZ = $player->getPosition()->getZ();

        if($xp < $totalCost){
            return $player->sendMessage("§7§l[§cFAIL§7] §r§7You can not afford x§c$amount §a| §c$IM");
        } else {
            $ii = ItemFactory::getInstance()->get($id);
            $vector3Pos = new Vector3($playerX, $playerY, $playerZ);
            if($playerInventory->canAddItem($ii)) {
                for($x = 0; $x < $amount; $x++) {
                    $playerInventory->addItem($ii);
                }
                $player->getXpManager()->addXp(-$totalCost, false);
                $player->sendMessage("§7§l[§aSUCCESS§7] §r§7You have purchased x§c$amount §a| §c$IM");
            } else {
                InvMenuHandler::getPlayerManager()->get($player)->removeCurrentMenu();
                $player->sendMessage(TF::RED . "Your inventory is full!");
            }
           }


    }
    public function foodMenu(Player $player, ?callable $callable = null){
        $foodmenu = InvMenu::create(InvMenu::TYPE_DOUBLE_CHEST);
        $foodmenu->setName(TF::RED . "WP " . TF::GREEN ."Shop");
        $inventory = $foodmenu->getInventory();

        $steak = VI::STEAK();
        $steak->setCustomName("§r§l§7[§r§c Steak §r§l§7]§r");
        $porkchop = VI::COOKED_PORKCHOP();
        $porkchop->setCustomName("§r§l§7[§r§c Cooked Porkchop §r§l§7]§r");
        $chicken = VI::COOKED_CHICKEN();
        $chicken->setCustomName("§r§l§7[§r§c Cooked Chicken §r§l§7]§r");
        $mutton = VI::COOKED_MUTTON();
        $mutton->setCustomName("§r§l§7[§r§c Cooked Mutton §r§l§7]§r");
        $rabbit = VI::COOKED_RABBIT();
        $rabbit->setCustomName("§r§l§7[§r§c Cooked Rabbit §r§l§7]§r");
        $salmon = VI::COOKED_SALMON();
        $salmon->setCustomName("§r§l§7[§r§c Cooked Salmon §r§l§7]§r");
        $fish = VI::COOKED_FISH();
        $fish->setCustomName("§r§l§7[§r§c Cooked Cod §r§l§7]§r");

        $bread = VI::BREAD();
        $bread->setCustomName("§r§l§7[§r§c Bread §r§l§7]§r");
        $gcarrot = VI::GOLDEN_CARROT();
        $gcarrot->setCustomName("§r§l§7[§r§c Golden Carrot §r§l§7]§r");



        $mstew = VI::MUSHROOM_STEW();
        $mstew->setCustomName("§r§l§7[§r§c Mushroom Stew §r§l§7]§r");
        $rstew = VI::RABBIT_STEW();
        $rstew->setCustomName("§r§l§7[§r§c Rabbit Stew §r§l§7]§r");
        $bsoup = VI::BEETROOT_SOUP();
        $bsoup->setCustomName("§r§l§7[§r§c Beetroot Soup §r§l§7]§r");
        $bpotato = VI::BAKED_POTATO();
        $bpotato->setCustomName("§r§l§7[§r§c Baked Potato §r§l§7]§r");
        $cookie = VI::COOKIE();
        $cookie->setCustomName("§r§l§7[§r§c Cookie §r§l§7]§r");
        $ppie = VI::PUMPKIN_PIE();
        $ppie->setCustomName("§r§l§7[§r§c Pumpkin Pie §r§l§7]§r");
        $cake = VB::CAKE()->asItem();
        $cake->setCustomName("§r§l§7[§r§c Cake §r§l§7]§r");  
        $dkelp = VI::DRIED_KELP();
        $dkelp->setCustomName("§r§l§7[§r§c Dried Kelp §r§l§7]§r");
        $gapple = VI::GOLDEN_APPLE();
        $gapple->setCustomName("§r§l§7[§r§c Golden Apple §r§l§7]§r");
        $back = VI::ARROW();
        $back->setCustomName("§l§c<- Back");

        $inventory->setItem(0, $steak);
        $inventory->setItem(1, $porkchop);
        $inventory->setItem(2, $chicken);
        $inventory->setItem(3, $mutton);
        $inventory->setItem(4, $rabbit);
        $inventory->setItem(5, $salmon);
        $inventory->setItem(6, $fish);
        $inventory->setItem(7, $bread);
        $inventory->setItem(8, $mstew);
        $inventory->setItem(9, $rstew);
        $inventory->setItem(10, $bsoup);
        $inventory->setItem(11, $bpotato);
        $inventory->setItem(12, $cookie);
        $inventory->setItem(13, $ppie);
        $inventory->setItem(14, $cake);
        $inventory->setItem(15, $dkelp);
        $inventory->setItem(16, $gapple);
        $inventory->setItem(17, $gcarrot);
        $inventory->setItem(49, $back);

        $foodmenu->setListener(function (InvMenuTransaction $tr)use($callable): InvMenuTransactionResult{
            $player = $tr->getPlayer();
            $item = $tr->getItemClicked();
            if($item->getId() == 262){
                $this->mainMenu($player);
            } else {
                $this->openPurchaseMenu($item, $player);
            }
            if($callable !== null){
                return $callable($tr);
            }
            return $tr->discard();
        });
        return $foodmenu->send($player);


    }

}