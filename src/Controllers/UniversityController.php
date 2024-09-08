<?php

namespace App\Controllers;

use App\Classes\View;
use App\Repositories\CourseRepository;
use App\Repositories\UserRepository;
use DI\Attribute\Inject;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Psr7\Request;

class UniversityController
{
    #[Inject]
    protected CourseRepository $courseRepository;

    #[Inject]
    protected UserRepository $userRepository;

    #[Inject]
    protected View $view;

    public function get(Request $request): ResponseInterface
    {
        $uid = $request->getAttribute('uid');
        $user = $this->userRepository->getExtended($uid);
        $query = $request->getQueryParams();
        $page = array_key_exists('page', $query) && ctype_digit($query['page']) ? $query['page'] : 1;

        return $this->view->render('university.twig', [
            'user' => $user,
            'courses' => $this->courseRepository->getPaginatedCourseList($page),
        ]);
    }

    public function viewCourse(Request $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $course = $this->courseRepository->getCourseBySlug($args['course']);
        if (!$course) {
            throw new HttpNotFoundException($request);
        }

        $uid = $request->getAttribute('uid');
        $user = $this->userRepository->getExtended($uid);

        $course->requirements = $this->expandRequirements($course);

        return $this->view->render('course.twig', [
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
