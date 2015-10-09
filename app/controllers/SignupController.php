<?php

use Phalcon\Mvc\Controller;

class SignupController extends Controller
{

	public function indexAction()
	{
		$ts = new Ts();
		print_r(get_class_methods($ts));
		echo 'xx';
	}

	public function registerAction()
	{
		// Instantiate the Query
		$query = $this->modelsManager->executeQuery("SELECT name,email FROM Users", $this->getDI());

// Execute the query returning a result if any
		//$cars = $query->execute();
		echo '<pre>';
		print_r($query);
		/*$q = $this->modelsManager->executeQuery('select * from Users');*/
		foreach ($query as $k=>$v) {
			echo $v;
		}
		die;
		$user = new Users();
//		print_r($this->request->getHeaders());
		$res = $user->query('select * from users');
		print_r($res);
print_r(get_class_methods($user));die;
		// Store and check for errors
		$success = $user->save(
			$this->request->getPost(),
			array('name', 'email')
		);

		if ($success) {
			echo "Thanks for registering!";
		} else {
			echo "Sorry, the following problems were generated: ";
			foreach ($user->getMessages() as $message) {
				echo $message->getMessage(), "<br/>";
			}
		}

		$this->view->disable();
	}

	public function signupAction()
	{
		var_dump($this->session->start());
		print_r(get_class_methods($this->session));

		$this->session->set('sign-user-name', 'Lijs');
		echo $this->session->get('sign-user-name');

		$this->session->set('kk', array('uniqueId' => 'my-app-1'));
		var_dump($this->session->get('kk'));
		var_dump($this->session->getId());
		print_r($_SESSION);
	}

	public function flashAction()
	{

		$this->flash->error("too bad! the form had errors");
		$this->flash->success("yes!, everything went very smoothly");
		$this->flash->notice("this a very important information");
		$this->flash->warning("best check yo self, you're not looking too good.");

		$this->flash->message("debug", "this is debug message, you don't say");

		$this->flashSession->success("Your information were stored correctly!");
		$this->flashSession->output();
	}

	public function formAction()
	{
		$app = new \Phalcon\Mvc\Micro();
echo $app->request->getRawBody();
		$app->post('/api/robots', function() use ($app) {

			$robot = json_decode($app->request->getRawBody());
			print_r($robot);
		});
	}

}
