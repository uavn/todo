<?php

class IndexController extends Controller {
  
  public function indexAction() {
    $todo = $this->getModel('todo');

    $items = $todo->fetchAll();

    return $this->render('index/index.phtml', [
      'items' => $items
    ]);
  }
}