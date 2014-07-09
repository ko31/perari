<?php
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * Connections Controller
 *
 * @property Connection $Connection
 * @property PaginatorComponent $Paginator
 */
class ConnectionsController extends AppController {

/**
 * Components
 *
 * @var array
 */

/**
 * index method
 *
 * @return void
 */
	public function index() {
	}

/**
 * chat method
 *
 * @return void
 */
	public function chat() {
		if ($this->request->is('post')) {
            $data = $this->request->data;
            $this->set('name', Sanitize::html($data['my-name']));
            $this->set('country', Sanitize::html($data['my-country']));
            $this->set('message', Sanitize::html($data['my-message']));
		}
	}

/**
 * progress method
 *
 * @return void
 */
	public function progress() {
        if (!$this->request->is('ajax')) {
            exit('Invalid access');
        }
		if ($this->request->is('post')) {
			$result = $this->Connection->progress($this->request->data);
			if (is_array($result)) {
                $this->viewClass = 'Json';
                $this->set(compact('result'));
                $this->set('_serialize', 'result');
            } elseif ($result === true) {
                $this->autoRender = false;
                echo "OK";
                exit;
            } else {
                $this->autoRender = false;
                echo "NG";
                exit;
            }
		}
	}

/**
 * finish method
 *
 * @return void
 */
	public function finish() {
        if (!$this->request->is('ajax')) {
            exit('Invalid access');
        }
		if ($this->request->is('post')) {
			if ($this->Connection->finish($this->request->data)) {
                $this->autoRender = false;
				echo "OK";
                exit;
            } else {
                $this->autoRender = false;
				echo "NG";
                exit;
            }
		}
	}

}
