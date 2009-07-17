<?php
namespace Gutshot\Models;

use Phalcon\Mvc\Model;
/**
 * ResetPasswords
 * Stores the reset password tokens and their evolution
 */
class Invitations extends Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $usersId;

    /**
     *
     * @var string
     */
    public $code;

    /**
     *
     * @var integer
     */
    public $createdAt;

    /**
     *
     * @var string
     */
    public $email;
    /**
     *
     * @var string
     */
    public $confirmed;

    /**
     * Before create the user assign a password
     */
    public function beforeValidationOnCreate()
    {
        // Timestamp the confirmaton
        $this->createdAt = time();

        // Generate a random confirmation token
        $this->code = preg_replace('/[^a-zA-Z0-9]/', '', base64_encode(openssl_random_pseudo_bytes(24)));

        $this->confirmed = 'No';
    }


    /**
     * Send an e-mail to users allowing him/her to reset his/her password
     */
    public function afterCreate()
    {

        $this->getDI()
            ->getMail()
            ->send(array(
                $this->email => $this->email
            ), "Please confirm your email", 'invitation', array(
                'invitationUrl' => '/invitation/' . $this->code . '/' . $this->email,
                'account' => $this->user->player,
            ));

    }

    public function initialize()
    {
        $this->belongsTo('usersId', __NAMESPACE__ . '\Users', 'id', array(
            'alias' => 'user'
        ));
    }
}
