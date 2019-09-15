<?php

namespace Tests\Feature;

use App\Models\Player;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class PlayerControllerTest extends TestCase
{
	use DatabaseMigrations;

	/**
	 * Test Player Index
	 */
	public function testPlayerIndex()
	{
		factory(Player::class, 20)->create();
		factory(Player::class)->create(['email' => 'test@admin.com']);

		$response = $this->call('GET', '/players');
		$this->assertEquals(200, $response->status());

		$this->json('GET', '/players')
		     ->seeJson([
					'status' => 'ok',
				])
			->seeJsonStructure( [ 'data' => [ [ 'id', 'name', 'role', 'email', 'created_at', 'updated_at' ] ] ] );

	}

	/**
	 * Test Player Store
	 */
	public function testPlayerStore()
	{
		$this->post( '/players', [ 'name' => 'Sally', 'role' => 'Point Guard', 'email' => 'test@admin.com' ] )
		     ->seeJsonStructure( [ 'data' => [ 'id', 'name', 'role', 'email', 'created_at', 'updated_at' ] ] )
		     ->seeJson( [
			     'status' => 'ok',
		     ] )
		     ->seeJson( [
			     'name' => 'Sally',
		     ] )
		     ->seeJson( [
			     'role' => 'Point Guard',
		     ] )
		     ->seeJson( [
			     'email' => 'test@admin.com',
		     ] );

		$this->seeInDatabase('players', ['email' => 'test@admin.com', 'role' => 'Point Guard']);
	}

	/**
	 * Test Player Show
	 */
	public function testPlayerShow()
	{
		/**
		 * Create 11 Players
		 */
		factory(Player::class, 10)->create();
		$player = factory(Player::class)->create([ 'name' => 'Sally', 'role' => 'Point Guard', 'email' => 'test@admin.com' ]);

		$response = $this->call('GET', "/players/{$player->id}");
		$this->assertEquals(200, $response->status());

		$this->json('GET', "/players/{$player->id}")
			->seeJsonStructure( [ 'data' => [ 'id', 'name', 'role', 'email', 'created_at', 'updated_at' ] ] )
			->seeJson( [
				'status' => 'ok',
			] )
			->seeJson( [
				'name' => 'Sally',
			] )
			->seeJson( [
				'role' => 'Point Guard',
			] )
			->seeJson( [
				'email' => 'test@admin.com',
			] );

		/**
		 * @GET( /players/12 ) is a 404
		 */
		$response = $this->call('GET', '/players/12');
		$this->assertEquals(404, $response->status());
	}

	/**
	 * Test Player Update
	 */
	public function testPlayerUpdate()
	{
		$player = factory(Player::class)->create([ 'name' => 'Sally', 'role' => 'Point Guard', 'email' => 'test@admin.com' ]);

		$this->seeInDatabase('players', ['name' => 'Sally', 'email' => 'test@admin.com', 'role' => 'Point Guard']);

		$this->put("/players/{$player->id}", [ 'name' => 'Noemy Walker', 'role' => 'Point Guard', 'email' => 'test@admin.com' ])
			->seeJsonStructure( [ 'data' => [ 'id', 'name', 'role', 'email', 'created_at', 'updated_at' ] ] )
			->seeJson( [
				'status' => 'ok',
			] )
			->seeJson( [
				'name' => 'Noemy Walker',
			] )
			->seeJson( [
				'role' => 'Point Guard',
			] )
			->seeJson( [
				'email' => 'test@admin.com',
			] );

		$this->seeInDatabase('players', ['name' => 'Noemy Walker', 'email' => 'test@admin.com', 'role' => 'Point Guard']);
	}

	/**
	 * Test Player Destroy
	 */
	public function testPlayerDestroy()
	{
		$player = factory(Player::class)->create([ 'name' => 'Sally', 'role' => 'Point Guard', 'email' => 'test@admin.com' ]);

		$this->delete("/players/{$player->id}")
		     ->seeJsonEquals( [
			     'message' => "Player {$player->id} deleted",
			     'status' => 'ok',
		     ] );

		$this->notSeeInDatabase('players', ['email' => 'test@admin.com']);

		/**
		 * Error message on second attempt
		 */
		$this->delete("/players/{$player->id}")
		     ->seeJsonEquals( [
			     'error' => 'Player ID Not Found',
			     'code' => 404,
		     ] );
	}
}
