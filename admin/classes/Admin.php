<?php
class Admin {

    private $users;
    private $courses;

    public function __construct($users, $courses) {
        $this->users = $users;
        $this->courses = $courses;
    }

    public function getUsers() {
        return $this->users;
    }
    public function deleteUser($id) {
        foreach ($this->users as $index => $user) {
            if ($user['id'] == $id) {
                unset($this->users[$index]);
                return true;
            }
        }
        return false;
    }

    public function getCourses() {
        return $this->courses;
    }

    public function deleteCourse($id) {
        foreach ($this->courses as $index => $course) {
            if ($course['id'] == $id) {
                unset($this->courses[$index]);
                return true;
            }
        }
        return false;
    }
    
        public function countUsers() {
        return count($this->users);
    }

    public function countCourses() {
        return count($this->courses);
    }


    public function searchCourses($term) {
        $result = [];

        foreach ($this->courses as $course) {
            if (stripos($course['title'], $term) !== false) {
                $result[] = $course;
            }
        }

        return $result;
    }
}
?>