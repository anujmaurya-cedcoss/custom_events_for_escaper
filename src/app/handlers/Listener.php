<?php
namespace App\Handlers;

use Phalcon\Escaper;

class Listener
{
    public function escape()
    {
        $escaper = new Escaper();
        return [
            $_POST['name'] = ($_POST['name'] == '' ? 'default' : $escaper->escapeHtml($_POST['name'])),
            $_POST['email'] = ($_POST['email'] == '' ? 'default@mail.com' : $escaper->escapeHtml($_POST['email']))
        ];
    }
}