<?php
namespace Gutshot\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Textarea;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\PresenceOf;
use Gutshot\Models\Users;

class SupportForm extends Form
{

    public function initialize()
    {
        $this->add(new Select('usersId', Users::find('active = "Y"'), array(
            'using' => array(
                'id',
                'player'
            ),
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => ''
        )));

        $content = new Text('content');
        $content->setLabel('Content');
        $content->addValidators(array(
            new PresenceOf(array(
                'message' => 'The content is required'
            ))
        ));
        $this->add($content);
    }

    /**
     * Prints messages for a specific element
     */
    public function messages($name)
    {
        if ($this->hasMessagesFor($name)) {
            foreach ($this->getMessagesFor($name) as $message) {
                $this->flash->error($message);
            }
        }
    }
}
