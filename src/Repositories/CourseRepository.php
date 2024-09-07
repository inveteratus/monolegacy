<?php

namespace App\Repositories;

use PDO;

class CourseRepository extends Repository
{
    public function getPaginatedCourseList(int $page = 1, int $ipp = 10): object
    {
        $records = $this->db->execute('SELECT COUNT(*) FROM courses')->fetch(PDO::FETCH_COLUMN);
        $pages = (int) ceil($records / $ipp);
        $page = max(1, min($page, $pages));
        $offset = ($page - 1) * $ipp;
        $courses = $this->db
            ->execute('SELECT * FROM courses ORDER BY name LIMIT :offset, :ipp', ['offset' => $offset, 'ipp' => $ipp])
            ->fetchAll(PDO::FETCH_UNIQUE);

        return (object)[
            'records' => $records,
            'pages' => $this->paginationButtons($page, $pages),
            'page' => $page,
            'ipp' => $ipp,
            'items' => $this->arrayOfObjects($courses),
        ];
    }

    public function getCourseBySlug(string $slug): ?object
    {
        $course = $this->db
            ->execute('SELECT * FROM courses WHERE slug = :slug', ['slug' => $slug])
            ->fetch(PDO::FETCH_OBJ);

        return $this->objectOrNull($course);
    }

    public function getCourseById(int $id): ?object
    {
        $course = $this->db
            ->execute('SELECT * FROM courses WHERE id = :id', ['id' => $id])
            ->fetch(PDO::FETCH_OBJ);

        return $this->objectOrNull($course);
    }
}
