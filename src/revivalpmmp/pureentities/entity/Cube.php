<?php
declare(strict_types=1);

namespace revivalpmmp\pureentities\entity;


use pocketmine\nbt\tag\CompoundTag;
use revivalpmmp\pureentities\data\NBTConst;
use revivalpmmp\pureentities\PluginConfiguration;

abstract class Cube extends MonsterPEX{

	protected $cubeSize = -1; // 0 = Tiny, 1 = Small, 2 = Big

	protected function initEntity() : void{
		parent::initEntity();
		if($this->cubeSize === -1){
			$this->cubeSize = self::getRandomCubeSize();
		}
		$this->setScale($this->cubeSize);
	}

	public static function getRandomCubeSize() : int{
		($size = mt_rand(1, 3)) !== 3 ?: $size = 4;
		return $size;
	}

	public function loadFromNBT(CompoundTag $nbt) : void{
		if(PluginConfiguration::getInstance()->getEnableNBT()){
			if($nbt->hasTag(NBTConst::NBT_KEY_CUBE_SIZE)){
				$cubeSize = $nbt->getByte(NBTConst::NBT_KEY_CUBE_SIZE, self::getRandomCubeSize());
				$this->cubeSize = $cubeSize;
			}
		}
	}

	public function saveNBT() : void{
		if(PluginConfiguration::getInstance()->getEnableNBT()){
			parent::saveNBT();
			$this->namedtag->setByte(NBTConst::NBT_KEY_CUBE_SIZE, $this->cubeSize, true);
		}
	}

	public function updateXpDropAmount() : void{
		// normally it would be set by small/medium/big sized - but as we have it not now - i'll make it more static
		if($this->cubeSize == 2){
			$this->xpDropAmount = 4;
		}else if($this->cubeSize == 1){
			$this->xpDropAmount = 2;
		}else{
			$this->xpDropAmount = 1;
		}
	}

}