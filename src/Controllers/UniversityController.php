<?php

namespace App\Controllers;

use App\Classes\Database;
use App\Repositories\PlayerRepository;
use DI\Attribute\Inject;
use PDO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UniversityController extends Controller
{
    #[Inject]
    private PlayerRepository $userRepository;

    #[Inject]
    private Database $db;
    public function get(Request $request, Response $response): Response
    {
        $uid = $request->getAttribute('uid');
        $user = $this->userRepository->getExtended($uid);
        $page = $request->getQueryParams()['page'] ?? 1;

        return $this->view('university.twig', [
            'user' => $user,
            'courses' => $this->getCourseList($page),
        ]);
    }

    private function getCourseList(int $page = 1): object
    {
        $records = $this->db->execute('SELECT COUNT(*) FROM courses')->fetch(PDO::FETCH_COLUMN);
        $ipp = 10;
        $pages = ceil($records / $ipp);
        $page = max(1, min($page, $pages));
        $offset = ($page - 1) * $ipp;
        $courses = $this->db
            ->execute('SELECT * FROM courses ORDER BY name LIMIT :offset, :ipp', ['offset' => $offset, 'ipp' => $ipp])
            ->fetchAll(PDO::FETCH_UNIQUE);

        $buttons = [1, 2, $page - 2, $page - 1, $page, $page + 1, $page + 2, $pages - 1, $pages];
        $buttons = array_unique($buttons);
        $buttons = (array)array_filter($buttons, fn ($p) => $p >= 1 && $p <= $pages);
        sort($buttons);

        return (object)[
            'pages' => $buttons,
            'page' => $page,
            'ipp' => $ipp,
            'items' => array_map(fn ($course) => (object) $course, $courses),
        ];
    }
}
