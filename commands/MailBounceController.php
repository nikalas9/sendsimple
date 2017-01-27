<?php

namespace app\commands;

use app\components\MailBounceHandler\Handler;
use app\models\MailerData;
use yii\console\Controller;
use yii\console\Exception;

class MailBounceController extends Controller
{
    public function actionIndex()
    {
        $accounts = Account::find()
            ->where('status = 1')
            ->all();
        foreach ($accounts as $account) {

            $cwsDebug = new \Cws\CwsDebug();
            $cwsMbh = new Handler($cwsDebug);
            // process mode
            //$cwsMbh->setNeutralProcessMode(); // default
            $cwsMbh->setMoveProcessMode();
            //$cwsMbh->setDeleteProcessMode();

            /*
             * Remote mailbox
             */
            $cwsMbh->setImapMailboxService(); // default
            $cwsMbh->setMailboxHost($account['imap_host']); // default 'localhost'
            $cwsMbh->setMailboxPort($account['imap_port']); // default const MAILBOX_PORT_IMAP
            $cwsMbh->setMailboxUsername($account['imap_username']);
            $cwsMbh->setMailboxPassword($account['imap_password']);
            $encryption = $account['imap_encryption'];
            if($encryption == ''){
                $encryption = 'none';
            }
            $cwsMbh->setMailboxSecurity($encryption);
            if(in_array($encryption,['tls','ssl'])){
                $cwsMbh->setMailboxCertValidate(); // default const MAILBOX_CERT_NOVALIDATE
            }

            //$cwsMbh->setMailboxName('SPAM'); // default 'INBOX'
            if ($cwsMbh->openImapRemote() === false) {
                throw new Exception( $cwsMbh->getError() );
            }
            $cwsMbh->setMaxMessages(1000);

            // process mails!
            $result = $cwsMbh->processMails();
            if (!$result instanceof \Cws\MailBounceHandler\Models\Result) {
                throw new Exception( $cwsMbh->getError() );
            } else {
                $mails = $result->getMails();
                foreach ($mails as $mail) {
                    if($mail->getRecipients()){
                        $recipient = $mail->getRecipients()[0];
                        //BlackList::import($recipient->getEmail());

                        if($messageId = $mail->getMessageId()){
                            $model = MailerData::find()
                                ->where(['message_id'=>$messageId])
                                ->one();
                            $model->status = -1;
                            $model->error = json_encode($recipient);
                        }
                    }
                }
            }
        }
    }
}
