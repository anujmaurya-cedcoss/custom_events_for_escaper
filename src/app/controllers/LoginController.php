<?php
use Phalcon\Mvc\Controller;
use App\Handlers\Listener;
use handler\Aware\Aware;
use Phalcon\Events\Manager as EventsManager;

class LoginController extends Controller
{
    public function IndexAction()
    {
        // nothing here
    }
    public function loginAction()
    {
        $user = new Users();
        $user->assign(
            $this->request->getPost(),
            [
                'name',
                'email'
            ]
        );
        $eventsManager = new EventsManager();
        $component = new Aware();

        $component->setEventsManager($eventsManager);
        $eventsManager->attach(
            'application:escape',
            new Listener()
        );
        $component->process();

        // query to find the user by name and email
        $query = $this->modelsManager->createQuery('SELECT * FROM Users WHERE name = :name: AND email = :email:');
        $usr = $query->execute([
            'name' => $user->name,
            'email' => $user->email
        ]);
        // if some result is found, then return as logged in, else user doesn't exist
        if (isset($usr[0])) {
            $this->view->success = true;
            $this->view->message = "LoggedIn succesfully";
        } else {
            $this->view->message = "Invalid Credentials";
        }
    }
}