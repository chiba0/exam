<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
	
use Cake\Routing\Router;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');

        //ログインチェック
        //ログインしていなければ、ログインフォームにリダイレクト
        $session = $this->request->session();
       
        //セッションに登録してあるdirと引数に付与されるdirが異なった際はログアウトを行う
        $dir = $session->read('Exam.dir');
        $params = explode("/",Router::url());
        if($dir != $params[3]){
            $session->delete("Exam.login");
        }
        $examlogin = $session->read('Exam.login');
        
        if(!$examlogin){
            $url = Router::url();
            if(!preg_match("/^\/users\/login/",$url)){
                header("Location:/users/login/");
                exit();
            }
        }else{
            $url = Router::url();
            $id = $session->read('Exam.dir');
            
            if(preg_match("/^\/exams\/logout/",$url)){
                $session->delete("Exam.login");
                header("Location:/users/login/".$id);
                exit();
            }

            if(!preg_match("/^\/exams/",$url)){
                header("Location:/exams/menu/".$id);
                exit();
            }
            

            
        }
        
        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
    }
}
