<?php
class Subtask {
    private $id;
    private $text;
    private $status;
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getText() {
        return $this->text;
    }

    public function setText($text) {
        $this->text = $text;
    }
        public function getSubStatus() {
        return $this->status;
    }

    public function setSubStatus($status) {
        $this->status = $status;
    }
}
?>