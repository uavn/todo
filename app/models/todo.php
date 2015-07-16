<?php

class Todo {
  public function fetchAll() {
    $stmt = $this->conn->prepare('SELECT * FROM `task` ORDER BY `id` DESC');
    $stmt->setFetchMode(PDO::FETCH_CLASS, 'Todo'); 
    $stmt->execute();

    $result = $stmt->fetchAll();

    return $result;
  }

  public function update($task) {
    $params = [
      'title' => strip_tags($task['title']),
      'desc' => strip_tags($task['desc']),
      'deadline' => $task['deadline']
    ];

    if ( $task['id'] ) {
      $stmt = $this->conn->prepare('UPDATE `task` SET `title` = :title, `desc` = :desc, `deadline` = :deadline WHERE `id` = :id');
      $params['id'] = $task['id'];
    } else {
      $stmt = $this->conn->prepare('INSERT INTO `task` VALUES (null, :title, :desc, :deadline)');
    }

    $status = $stmt->execute($params);

    if ( !$status ) {
      throw new Exception("Error task creation", 500);
    }

    return $task['id'] ? $task['id'] : $this->conn->lastInsertId();
  }

  public function delete($id) {
    $stmt = $this->conn->prepare('DELETE FROM `task` WHERE id = :id');
    $status = $stmt->execute([
      'id' => $id
    ]);

    if ( !$status ) {
      throw new Exception("Error task creation", 500);
    }

    return $status;
  }
}