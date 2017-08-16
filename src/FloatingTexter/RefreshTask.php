<?php

namespace FloatingTexter;

use pocketmine\scheduler\PluginTask;

class RefreshTask extends PluginTask{

    private $plugin;

    public function __construct(Main $plugin){
        $this->plugin = $plugin;
        parent::__construct($plugin);
    }

    public function onRun($currentTick){
        foreach($this->plugin->getServer()->getLevels() as $level){
            foreach($level->getEntities() as $entity){
                if($entity instanceof FloatingText){
                    $entity->despawnFromAll();
                    $entity->spawnToAll();
                }
            }
        }
    }
}