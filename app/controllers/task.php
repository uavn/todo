<?php

class TaskController extends Controller {
  
  public function newAction() {
    $task = [
      'id' => $this->getParam('id'),
      'title' => $this->getParam('title'),
      'desc' => $this->getParam('desc'),
      'deadline' => $this->getParam('y', date('Y')) . '-' . $this->getParam('m', date('m')) . '-' . $this->getParam('d', date('d')) . ' ' . $this->getParam('h', '00') . ':' . $this->getParam('i', '00') . ':00',
    ];

    $todo = $this->getModel('todo');
    $status = $todo->update($task);
    
    return $status;
  }

  public function removeAction() {
    $todo = $this->getModel('todo');
    $status = $todo->delete($this->getParam('id'));

    return $status;
  }
}