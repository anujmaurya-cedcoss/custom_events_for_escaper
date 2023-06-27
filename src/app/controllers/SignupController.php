<?php
use Phalcon\Mvc\Controller;
use App\Handlers\Listener;
use handler\Aware\Aware;
use Phalcon\Events\Manager as EventsManager;

class SignupController extends Controller
{
    public function IndexAction()
    {
        // nothing here
    }

    public function registerAction()
    {
        // creating a new user, with name and email obtained by post method
        $user = new Users();
        
        $eventsManager = new EventsManager();
        $component = new Aware();

        $component->setEventsManager($eventsManager);
        $eventsManager->attach(
            'application:escape',
            new Listener()
        );
        $component->process();
        
        $user->assign(
            $_POST,
            [
                'name',
                'email'
            ]
        );
        // if the user details is saved, then return success
        $success = $user->save();
        $this->view->success = $success;
        if ($success) {
            $this->view->message = "Register succesfully";
        } else {
            $this->view->message = "Not Register due to following reason: <br>" . implode("<br>", $user->getMessages());
        }
    }
}