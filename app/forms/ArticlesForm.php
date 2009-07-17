<?php
namespace Gutshot\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Textarea;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;

class ArticlesForm extends Form
{

    public function initialize($entity = null, $options = null)
    {
        // In edition the id is hidden
        if (isset($options['edit']) && $options['edit']) {
            $id = new Hidden('id');
        } else {
            $id = new Text('id');
        }
        $this->add($id);

        $title = new Text('title');
        $title->setLabel('Title');
        $title->addValidators(array(
            new PresenceOf(array(
                'message' => 'The title is required'
            ))
        ));
        $this->add($title);

        $this->add(new Select('type', array("news" => "News",
            "rules" => "Rules",
            "faq" => "FAQ",
            "instruction" => "Instruction",
            "prize" => "Prize"
        ),
            array(
                'useEmpty' => false,
                'value' => 'News'
            )
        ));

        $content = new Textarea('content');
        $content->setLabel('Content');
        $content->addValidators(array(
            new PresenceOf(array(
                'message' => 'The content is required'
            ))
        ));
        $this->add($content);

        $createdAtFrom = new Text('createdAtFrom', array(
            'data-format' => 'dd-MM-yyyy hh:mm:ss'
        ));
        $this->add($createdAtFrom);

        $createdAtTo = new Text('createdAtTo', array(
            'data-format' => 'dd-MM-yyyy hh:mm:ss'
        ));
        $this->add($createdAtTo);
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
