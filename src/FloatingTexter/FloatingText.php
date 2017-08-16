<?php

namespace FloatingTexter;

use pocketmine\entity\Entity;
use pocketmine\entity\Item;
use pocketmine\level\Level;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class FloatingText extends Entity{

    /** @var string */
    public $text;

    public function __construct(Level $level, CompoundTag $nbt, string $text = ""){
        $this->setNameTag($text);
        parent::__construct($level, $nbt);
    }

    public function spawnTo(Player $player) {
        $pk = new AddEntityPacket();
        $pk->entityRuntimeId = $this->getId();
        $pk->type = Item::NETWORK_ID;
        $pk->x = $this->x;
        $pk->y = $this->y - 0.75;
        $pk->z = $this->z;
        $pk->speedX = 0;
        $pk->speedY = 0;
        $pk->speedZ = 0;
        $pk->yaw = 0;
        $pk->pitch = 0;
        $flags = (
            (1 << Entity::DATA_FLAG_CAN_SHOW_NAMETAG) |
            (1 << Entity::DATA_FLAG_ALWAYS_SHOW_NAMETAG) |
            (1 << Entity::DATA_FLAG_IMMOBILE)
        );
        $pk->metadata = [
            Entity::DATA_FLAGS => [Entity::DATA_TYPE_LONG, $flags],
            Entity::DATA_NAMETAG => [Entity::DATA_TYPE_STRING, str_replace(["{name}", "{tps}", "{players}", "{maxplayers}", "{load}", "{line}"], [$player->getName(), $this->server->getTicksPerSecond(), count($this->server->getOnlinePlayers()), $this->server->getMaxPlayers(), $this->server->getTickUsage(), "\n"], $player->isOp() ? $this->getNameTag() . "\n" . TextFormat::GREEN . "ID: " . $this->getId() : $this->getNameTag())],
        ];
        $player->dataPacket($pk);
    }
}