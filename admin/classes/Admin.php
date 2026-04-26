<?php
class Admin {

    public function getUsers() {
        return getData(DATA_DIR . '/users.php');
    }

    public function getCourses() {
        return getData(DATA_DIR . '/courses.php');
    }

    public function getPurchases() {
        return getData(DATA_DIR . '/purchases.php');
    }

    public function deleteUser($id) {
        $users = array_values(array_filter($this->getUsers(), fn($u) => $u['id'] != $id));
        saveData(DATA_DIR . '/users.php', $users);
    }

    public function deleteCourse($id) {
        $courses = $this->getCourses();
        foreach ($courses as $c) {
            if ($c['id'] == $id && !empty($c['file'])) {
                $f = ROOT_DIR . '/' . $c['file'];
                if (file_exists($f)) @unlink($f);
            }
        }
        $courses = array_values(array_filter($courses, fn($c) => $c['id'] != $id));
        saveData(DATA_DIR . '/courses.php', $courses);
    }

    public function searchCourses($term) {
        return array_filter($this->getCourses(), function($c) use ($term) {
            return stripos($c['title'], $term) !== false
                || stripos($c['description'], $term) !== false;
        });
    }

    public function countUsers()     { return count($this->getUsers()); }
    public function countCourses()   { return count($this->getCourses()); }
    public function countPurchases() { return count($this->getPurchases()); }
}
