<?php

namespace App\Controllers;

use App\Repositories\CourseRepository;
use App\Repositories\PlayerRepository;
use DI\Attribute\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;

class UniversityController extends Controller
{
    #[Inject]
    private CourseRepository $courseRepository;

    #[Inject]
    private PlayerRepository $userRepository;

    public function get(Request $request, Response $response): Response
    {
        $uid = $request->getAttribute('uid');
        $user = $this->userRepository->getExtended($uid);
        $query = $request->getQueryParams();
        $page = array_key_exists('page', $query) && ctype_digit($query['page']) ? $query['page'] : 1;

        return $this->view('university.twig', [
            'user' => $user,
            'courses' => $this->courseRepository->getPaginatedCourseList($page),
        ]);
    }

    public function viewCourse(Request $request, Response $response, array $args): Response
    {
        $course = $this->courseRepository->getCourseBySlug($args['course']);
        if (!$course) {
            throw new HttpNotFoundException($request);
        }

        $uid = $request->getAttribute('uid');
        $user = $this->userRepository->getExtended($uid);

        $course->requirements = $this->expandRequirements($course);

        return $this->view('course.twig', [
            'user' => $user,
            'course' => $course,
        ]);
    }

    private function expandRequirements(object $course): array
    {
        $completed = [];
        $result = [];

        foreach (json_decode($course->requirements ?? '[]', true) as $key => $value) {
            if ($key == 'completed') {
                $completed[] = $this->courseRepository->getCourseById($value);
            } else {
                $result[] = number_format($value) . ' ' . $key;
            }
        }

        return array_merge($completed, $result);
    }
}
