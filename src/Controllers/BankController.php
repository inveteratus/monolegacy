<?php

namespace App\Controllers;

use App\Repositories\PlayerRepository;
use DI\Attribute\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BankController extends Controller
{
    #[Inject]
    private PlayerRepository $playerRepository;

    public function get(Request $request): Response
    {
        $uid = $request->getAttribute("uid");
        $user = $this->playerRepository->getBasic($uid);

        return $this->view('bank.twig', [
            'user' => $user,
            'deposit' => $this->buttons($user->money, $user->level),
            'withdraw' => $this->buttons($user->bankmoney, $user->level),
        ]);
    }

    public function post(Request $request): Response
    {
        $uid = $request->getAttribute("uid");
        $user = $this->playerRepository->getBasic($uid);
        $deposit = $this->buttons($user->money, $user->level);
        $withdraw = $this->buttons($user->bankmoney, $user->level);
        $params = (array)$request->getParsedBody();

        if (array_key_exists('deposit', $params) && ctype_digit($params['deposit']) && in_array($params['deposit'], $deposit)) {
            $this->playerRepository->deposit($uid, $params['deposit']);
        }
        elseif (array_key_exists('withdraw', $params) && ctype_digit($params['withdraw']) && in_array($params['withdraw'], $withdraw)) {
            $this->playerRepository->withdraw($uid, $params['withdraw']);
        }

        return $this->redirect('/bank');
    }

    private function buttons(int $amount, int $level): array
    {
        $factor1 = (floor(($level - 1) / 5) % 2) * 4 + 1;
        $factor2 = 10 ** (floor(($level - 1) / 10) + 2);
        $result = [];
        $button = $factor1 * $factor2;

        while ($button <= $amount) {
            $result[] = $button;
            if (count($result) > 5) {
                array_shift($result);
            }
            $button *= str_starts_with($button, '1') ? 5 : 2;
        }

        return $result;
    }
}
