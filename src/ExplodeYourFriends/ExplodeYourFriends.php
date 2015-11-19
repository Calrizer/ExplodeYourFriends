<?php

//This is open source, please feel free to use any of my code in your plugins!
//Just don't re-upload it as your own work!
//
//By Calrizer (Callum Drain).

namespace ExplodeYourFriends;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\event\entity\ExplosionPrimeEvent;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\Server;
use pocketmine\entity\PrimedTNT;
use pocketmine\level\Explosion;
use pocketmine\level\Position;

class ExplodeYourFriends extends PluginBase implements Listener{
    
    public function onEnable(){
        
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        
        $this->getLogger()->info("§cExplodeYourFriends §fby §aCalrizer §floaded!");
    }
    
    public function onCommand(CommandSender $sender, Command $command, $label, array $args){
        
        switch($command->getName()){
                
                case "explode":
			
			if(count($args) !== 1 xor 2){
				$sender->sendMessage("§cUsage: §f" . $command->getUsage());
				return true;
			}
				
                $player = $args[0];
                
                $force = $args[1];
                
                if(count($args) === 2){
                	$this->explodePlayer($player, $sender, $force);
                	return true;
                }else{
                	$this->explodePlayer($player, $sender, 2);
               		return true;
                }
        }
        
    }
    
    public function explodePlayer($player, $sender, $force){
        
        $exploded = false;
        
        foreach($this->getServer()->getOnlinePlayers() as $p){
            if($p->getName() === $player){
                
                $sender->sendMessage("§f[§cEYF§f] §9".$player." §fwas blown up!");
                
                $p->sendMessage("§c".$sender->getName()." §fblew you up!");
                
                $position = $p->getPosition();
                
                $explosion = new Explosion($position, $force, $this);
                    
                $explosion->explodeB();
                
                $exploded = true;
                
                break;
            }
        }
        
        if($exploded === false){
            $sender->sendMessage("§f[§cEYF§f] Could not find player §9".$player);
        }
    }
}
?>
