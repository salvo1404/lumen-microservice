<?php

namespace App\Events;

use App\Models\Player;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PlayerPubSub implements ShouldBroadcast
{
	/**
	 * @var Player $player
	 */
	public $player;

	/**
	 * @var string $status
	 */
	public $status;

	/**
	 * Create a new event instance.
	 *
	 * @param Player $player
	 * @param string $status
	 */
	public function __construct(Player $player, string $status)
	{
		$this->player = $player;
		$this->status = $status;
	}

	/**
	 * Get the channels the event should be broadcast on.
	 *
	 * @return array
	 */
	public function broadcastOn()
	{
		return ['playerPubSub.'.$this->player->id];
	}
}
