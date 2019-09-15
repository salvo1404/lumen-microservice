<?php

namespace App\Http\Controllers\Player;

use App\Events\PlayerPubSub;
use App\Http\Controllers\Controller;
use App\Repositories\PlayerRepositoryInterface;
use App\Traits\ApiResponser;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class PlayerController extends Controller
{
	use ApiResponser;

	protected $requestRules = [
		'name'  => 'required|string',
		'role'  => 'required|string',
		'email' => 'required|email',
	];

	/**
	 * @var PlayerRepositoryInterface
	 */
	private $playerRepository;

	/**
	 * Create a new controller instance.
	 *
	 * @param PlayerRepositoryInterface $playerRepository
	 */
	public function __construct(PlayerRepositoryInterface $playerRepository)
	{
		$this->playerRepository = $playerRepository;
	}

	/**
	 * Return full list of players
	 *
	 * @Get("/players")
	 *
	 * @return JsonResponse
	 */
	public function index()
	{
		$players = $this->playerRepository->getAll();

		return $this->successResponseWithData($players);
	}

	/**
	 * Create one new player
	 *
	 * @Post("players")
	 *
	 * @param Request $request
	 *
	 * @return JsonResponse
	 * @throws ValidationException
	 */
	public function store(Request $request)
	{
		$this->validate($request, $this->requestRules);

		$player = $this->playerRepository->create( $request->all() );

		if (!$player) {
			return $this->errorResponse('Error in creating the player', Response::HTTP_CONFLICT);
		}

		broadcast(new PlayerPubSub($player, 'created'))->toOthers();

		return $this->successResponseWithData($player, Response::HTTP_CREATED);
	}


	/**
	 * View a specific player
	 *
	 * @Get("players/{id}" where={"id": "[0-9]+"})
	 *
	 * @param int $playerId
	 * @return JsonResponse
	 */
	public function show(int $playerId)
	{
		$player = $this->playerRepository->find($playerId);

		if ( ! $player) {
			return $this->errorResponse('Player Not Found', Response::HTTP_NOT_FOUND);
		}

		return $this->successResponseWithData($player);
	}

	/**
	 * Update player information
	 *
	 * @Put("players/{id}" where={"id": "[0-9]+"})
	 *
	 * @param Request $request
	 * @param int     $playerId
	 *
	 * @return JsonResponse
	 * @throws ValidationException
	 */
	public function update(Request $request, int $playerId)
	{
		$this->validate($request, $this->requestRules);

		$player = $this->playerRepository->find($playerId);
		if ( ! $player) {
			return $this->errorResponse('Player Not Found', Response::HTTP_NOT_FOUND);
		}

		try {
			$playerUpdated = $this->playerRepository->update($playerId, $request->all());

		} catch ( QueryException $exception ) {
			return $this->errorResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
		}

		if (!$playerUpdated) {
			return $this->errorResponse('Error in updating Player', Response::HTTP_BAD_REQUEST);
		}

		broadcast(new PlayerPubSub($playerUpdated, 'updated'))->toOthers();

		return $this->successResponseWithData($playerUpdated, Response::HTTP_OK);
	}


	/**
	 * Delete player information
	 *
	 * @Delete("players/{id}" where={"id": "[0-9]+"})
	 *
	 * @param int $playerId
	 * @return JsonResponse
	 */
	public function destroy(int $playerId)
	{
		$player = $this->playerRepository->find($playerId);
		if ( ! $player) {
			return $this->errorResponse('Player ID Not Found', Response::HTTP_NOT_FOUND);
		}

		$deleted = $this->playerRepository->delete($playerId);

		if(!$deleted){
			return $this->errorResponse('Error in deleting the player', Response::HTTP_NOT_FOUND);
		}

		broadcast(new PlayerPubSub($player, 'deleted'))->toOthers();

		return $this->successResponseWithMessage('Player '.$playerId. ' deleted', Response::HTTP_ACCEPTED);
	}
}
