<?php
declare(strict_types=1);

/**
 * PureEntitiesX: Mob AI Plugin for PMMP
 * Copyright (C)  2018 RevivalPMMP
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace revivalpmmp\pureentities\entity;

use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\network\mcpe\protocol\MobEquipmentPacket;
use pocketmine\Player;

class WitherSkeleton extends Skeleton{
	const NETWORK_ID = self::WITHER_SKELETON;

	public function getName() : string{
		return "Wither Skeleton";
	}

	public function spawnTo(Player $player) : void{
		parent::spawnTo($player);

		$pk = new MobEquipmentPacket();
		$pk->entityRuntimeId = $this->getId();
		$pk->item = ItemFactory::get(ItemIds::STONE_SWORD);
		$pk->inventorySlot = 10;
		$pk->hotbarSlot = 10;
		$player->dataPacket($pk);
	}

	public function getDrops() : array{
		$drops = parent::getDrops();
		switch(mt_rand(0, 8)){
			case 1:
				$drops[] = Item::get(Item::MOB_HEAD, 1, mt_rand(0, 2));
				break;
		}
		return $drops;
	}

	protected function equipDefaultMainHand() : void{
		$this->mobEquipment->setMainHand(ItemFactory::get(Item::STONE_SWORD));
	}

}
