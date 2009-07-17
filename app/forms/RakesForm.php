<?php
namespace Gutshot\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Gutshot\Models\Users;

class RakesForm extends Form
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

        $this->add(new Select('toId', Users::find('active = "Y"'), array(
            'using' => array(
                'id',
                'player'
            ),
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => ''
        )));

        $this->add(new Select('fromId', Users::find('active = "Y"'), array(
            'using' => array(
                'id',
                'player'
            ),
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => ''
        )));

        $createdAtFrom = new Text('createdAtFrom', array(
            'data-format' => 'dd-MM-yyyy hh:mm:ss'
        ));
        $this->add($createdAtFrom);

        $createdAtTo = new Text('createdAtTo', array(
            'data-format' => 'dd-MM-yyyy hh:mm:ss'
        ));
        $this->add($createdAtTo);
    }
}
