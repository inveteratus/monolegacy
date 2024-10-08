<?php

namespace App\Controllers;

use App\Classes\View;
use App\Repositories\UserRepository;
use DI\Attribute\Inject;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Routing\RouteContext;

class BankController
{
    #[Inject]
    protected UserRepository $userRepository;

    #[Inject]
    protected View $view;

    public function __invoke(Request $request): ResponseInterface
    {
        $user = $this->userRepository->get($request->getAttribute('uid'));

        return $this->view->render('bank.twig', [
            'user' => $user,
            'deposit' => $this->buttons($user->cash, $user->level),
            'withdraw' => $this->buttons($user->bank, $user->level),
        ]);
    }

    public function transfer(Request $request): ResponseInterface
    {
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();

        $uid = $request->getAttribute("uid");
        $user = $this->userRepository->get($uid);
        $deposit = $this->buttons($user->cash, $user->level);
        $withdraw = $this->buttons($user->bank, $user->level);
        $params = (array)$request->getParsedBody();

        if (
            array_key_exists('deposit', $params)
            && ctype_digit($params['deposit'])
            && in_array($params['deposit'], $deposit)
        ) {
            $this->userRepository->deposit($uid, $params['deposit']);
        } elseif (
            array_key_exists('withdraw', $params)
            && ctype_digit($params['withdraw'])
            && in_array($params['withdraw'], $withdraw)
        ) {
            $this->userRepository->withdraw($uid, $params['withdraw']);
        }

        return redirect($routeParser->urlFor('bank'));
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
            $button *= str_starts_with((string) $button, '1') ? 5 : 2;
        }

        return $result;
    }
}
