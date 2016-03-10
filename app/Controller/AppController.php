<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');
App::uses('CakeTime', 'Utility');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	public $helpers = array(
		'Js', 
		'Html', 
		'Form2', 
		'Session',
		'Facebook.Facebook'
	);

	public $components = array(
		'RequestHandler',
		'Session',
	    'Auth' => array(
	        'loginAction' => array(
	            'controller' => 'users',
	            'action' => 'login'
	        ),
	        'authError' => 'Incorrect username/password(1).',
	        'authenticate' => array(
	            'Form' => array(
	                'passwordHasher' => array(
	                    'className' => 'Simple',
	                    'hashType' => 'sha256'
	                ),
	                'fields' => array(
	                	'username' => 'username', //Default is 'username' in the userModel
	                	'password' => 'password'  //Default is 'password' in the userModel
	                )
	            )
	        )
    	),
    	'Facebook.Connect' => array('model'=>'User')
 	);

	public $objLoggedUser = null;
	public $isAdmin;
	public $logged_in = null;
	public $errorMsg = null;
	private $additionalCss = array();
	private $additionalJs = array();
	private $additionalJsTmp = array();


/**
*
*	beforeRender
*
**/	
	public function beforeRender() {
		$this->set('logged_in', $this->_loggedIn());
		$this->set('username', $this->_username());
		$this->set('isAdmin', $this->isAdmin());
		$this->set('objLoggedUser', $this->objLoggedUser);
		$this->set('today', $this->_today());
	}

/**
*
*	beforefilter
*
**/	
    public function beforeFilter() {

		if($this->Auth->user('id')){
			$this->loadModel('User');
			$this->objLoggedUser = $this->User->findById($this->Auth->user('id'));
		}

		
    }

	/**
	* This function return true if user is Admin 
	**/
	public function isAdmin() {
	    // Admin and Developers can access every action
		$this->loadModel('User');
	    if ( $this->User->find('first', array('conditions'=>array('User.id'=>$this->Auth->user('id'),'User.role_id'=>'1')))) {
		        return true;
	    }

	    // Default deny
	    return false;
	}

	/**
	* This function return today's date
	**/
	public function _today() {
	    return date("Y-m-d H:i:s");
	}

	/**
	* This function return if there is a user logged in
	**/
	public function _loggedIn(){
		return ($this->Auth->user() ? true : false);
	}
	
	/**
	* This function return the username logged in
	**/
	function _username() {
		if($this->Auth->user()) {
			return $this->Auth->user('username');
		}
		return null;
		
	}

	/**
	* This function does the same thing as the View::element and return the rendered element.
	* This is useful when you need the html of an element in a controller
	**/
	public function element($name, $data = array(), $options = array()){
		$tmpView = new View();
		$tmpView->helpers = $this->helpers;
		$tmpView->loadHelpers();
		$data['objRequest'] =& $this->request;
		$data['objController'] =& $this;
		$return = $tmpView->element($name, $data, $options);
		unset($tmpView);
		return $return;
	}

	public function listAditionalJs(){
		ksort($this->additionalJs);
		
		return $this->additionalJs;
	}
	
	public function loadAditionalJs($jsFileName,$priority=99){
		if(!in_array($jsFileName,$this->additionalJsTmp)){	
			$this->additionalJsTmp[] = $this->additionalJs[$priority][] = $jsFileName;
		}	
	}
	
	
	public function listAditionalCss(){
		return $this->additionalCss;
	}
	
	public function loadAditionalCss($cssFileName){
		if(!in_array($cssFileName,$this->additionalCss)){
			$this->additionalCss[] = $cssFileName;
		}	
	}

	function beforeFacebookLogin($user){

	}

	function afterFacebookLogin(){

    	$this->redirect('/');

	}

	//Add an email field to be saved along with creation.
	function beforeFacebookSave(){

		$this->Connect->authUser['User']['username'] = $this->Connect->user('name');
		$this->Connect->authUser['User']['email'] = $this->Connect->user('email');
		$this->Connect->authUser['User']['active'] = '1';
		$this->Connect->authUser['User']['online'] = '1';
		$this->Connect->authUser['User']['role_id'] = '9';

	    return true; //Must return true or will not save.

	}

}
