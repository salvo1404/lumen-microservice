<?php

namespace App\Repositories;


use App\Models\Player;
use Illuminate\Database\QueryException;

class PlayerRepository implements PlayerRepositoryInterface
{

	/**
	 * Return full list of players
	 *
	 * @return Player[]
	 */
	public function getAll() {
		return Player::all();
	}

	/**
	 * Find a specific player
	 *
	 * @param $id
	 *
	 * @return mixed
	 */
	public function find(int $id)
	{
		return ( new Player )->find($id);
	}

	/**
	 * Create one new player
	 *
	 * @param array $data
	 *
	 * @return Player|null
	 */
	public function create(array $data)
	{
		$player      = new Player;
		$playerExist = $player->where( 'email', $data['email'] )->first();
		if ( $playerExist ) {
			return null;
		}

		return $player->create($data);
	}

	/**
	 * Update player information
	 *
	 * @param int   $id
	 * @param array $data
	 *
	 * @return Player
	 * @throws QueryException
	 */
	public function update(int $id, array $data)
	{
		$player = ( new Player )->where( 'id', $id )->first();

		$player->fill( $data );
		$player->save();

		return $player;
	}

	/**
	 * Delete player information
	 *
	 * @param int $id
	 *
	 * @return int
	 */
	public function delete( int $id ) {
		return Player::destroy( $id );
	}

}
