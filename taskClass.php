<?php
class Task {
    private $id;
    private $title;
    private $description;
    private $creationDate;
    private $endDate;
    private $status;
    private $category;
    private $subtasks; // lista de subtask-uri

    public function __construct() {
        $this->subtasks = array(); // inițializăm lista de subtask-uri ca un array gol
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }

    public function getEndDate() {
        return $this->endDate;
    }

    public function setEndDate($endDate) {
        $this->endDate = $endDate;
    }
    public function isExpired() {
        $today = new DateTime();
        $endDate = new DateTime($this->getEndDate());
        return ($endDate < $today)&&$this->getStatus()!="Terminat";
    }
    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getCategory() {
        return $this->category;
    }

    public function setCategory($category) {
        $this->category = $category;
    }

    public function addSubtask($subtask) {
        $this->subtasks[] = $subtask;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }


    public function getEmail()
    {
        return $this->email;
    }
    public function getSubtasks() {
        return $this->subtasks;
    }

      public function setSubtasks($subtasks)
    {
        $this->subtasks = $subtasks;
    }
}
?>