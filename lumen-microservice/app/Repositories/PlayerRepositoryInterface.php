<?php

namespace App\Repositories;

use App\Models\Player;
use Illuminate\Database\QueryException;

interface PlayerRepositoryInterface
{
	/**
	 * Return full list of players
	 *
	 * @return Player[]
	 */
	public function getAll();

	/**
	 * Find a specific player
	 *
	 * @param int $id
	 * @return mixed
	 */
	public function find(int $id);

	/**
	 * Create one new player
	 *
	 * @param array $data
	 * @return Player|null
	 */
	public function create(array $data);

	/**
	 * Update player information
	 *
	 * @param int   $id
	 * @param array $data
	 *
	 * @return Player
	 * @throws QueryException
	 */
	public function update(int $id, array $data);

	/**
	 * Delete player information
	 *
	 * @param int $id
	 *
	 * @return int
	 */
	public function delete(int $id);
}
