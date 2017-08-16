<?php

namespace FloatingTexter;

use pocketmine\scheduler\PluginTask;

class SpawnTask extends PluginTask{

    /** @var FloatingText */
    public $floatingText;
    public $plugin;

    public function __construct(Main $plugin, FloatingText $floatingText){
        $this->plugin = $plugin;
        $this->floatingText = $floatingText;
        parent::__construct($plugin);
    }

    public function onRun($currentTick){
        $this->floatingText->spawnToAll();
    }
}