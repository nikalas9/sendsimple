<?php
namespace app\controllers;

use app\models\Account;
use core\components\AdminController;
use Yii;



use app\models\Clients;
use app\models\ClientsBase;
use app\models\Mailer;
use app\models\MailerData;
use yii\base\Exception;


/**
 * Site controller
 */
class MailerController extends AdminController
{
    public $modelClass = 'app\models\Mailer';

    public $modelSearchClass = 'app\models\MailerSearch';


    function actionSend()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try
        {
            $mailer = Mailer::find()
                ->where('status = 1')
                ->orderBy('id asc')
                ->one();
            if($mailer) {
                if($mailer->base_ids){
                    $baseIds = explode(',',$mailer->base_ids);

                    $clients = Clients::find()
                        ->leftJoin(ClientsBase::tableName(),'tbl_clients_base.client_id = tbl_clients.id')
                        ->where([
                            ClientsBase::tableName().'.base_id'=>$baseIds
                        ])
                        ->all();
                    if($clients) {
                        foreach ($clients as $client) {
                            $model = new MailerData();
                            $model->status = 0;
                            $model->client_id = $client->id;
                            $model->client_email = $client->email;
                            $model->base_id = $baseIds[0];
                            $model->mailer_id = $mailer->id;
                            $model->lang_id = $mailer->lang_id;
                            $model->save(false);
                        }
                    }
                }
                $mailer->status = 2;
                $mailer->save(false);
            }

            $transaction->commit();
        }
        catch(Exception $e)
        {
            $transaction->rollback();
            throw $e;
        }

        $mailer = Mailer::find()
            ->where('status = 2')
            ->orderBy('id asc')
            ->one();
        if($mailer){
            $list = MailerData::find()
                ->where([
                    'status'=>0,
                    'mailer_id'=>$mailer->id,
                ])
                ->all();
            if($list) {
                foreach ($list as $row) {
                    $row->senderMail($mailer);
                }
            }
            $mailer->status = 3;
            $mailer->save(false);
        }
    }

    function actionBounce()
    {
        $accounts = Account::find()
            ->where('status = 1')
            ->all();
        foreach ($accounts as $account){


            $mailbox = new \roopz\imap\Imap();
            $connection = [
                'imapPath' => $account['imap_path'],
                'imapLogin' => $account['imap_username'],
                'imapPassword' => $account['imap_password'],
                'serverEncoding'=>'utf-8', // utf-8 default.
                'attachmentsDir'=>'/'
            ];
            $mailbox->setConnection($connection);
            $mailbox->createConnection();

            $mailIds = $mailbox->searchMailBox('ALL');// Prints all Mail ids.
            foreach ($mailIds as $mailId) {

                $mail = $mailbox->getMail($mailId);

                $temp_file = tempnam(sys_get_temp_dir(), 'eml_');
                $mailbox->saveMail($mailId, $temp_file);

                $parser = new \app\components\BounceMailParser();
                $parser->parseFile($temp_file);

                @unlink($temp_file);
                $mailbox->deleteMail($mailId);
            }



            //print_r($mailIds);

            //$mail = $mailbox->getMail(7);
            $options = FT_UID;
            $mail = imap_qprint(imap_body($mailbox->getImapStream(), 1));
            //print_r($mail);




        }
    }

    function actionBounce2()
    {
        $cwsDebug = new \Cws\CwsDebug();
        //$cwsDebug->setDebugVerbose();
        //$cwsDebug->setEchoMode();

        $cwsMbh = new \Cws\MailBounceHandler\Handler($cwsDebug);

        // process mode
        $cwsMbh->setNeutralProcessMode(); // default
        //$cwsMbh->setMoveProcessMode();
        //$cwsMbh->setDeleteProcessMode();



        /*
         * Remote mailbox
         */
        $cwsMbh->setImapMailboxService(); // default
        $cwsMbh->setMailboxHost('imap.yandex.ru'); // default 'localhost'
        $cwsMbh->setMailboxPort(993); // default const MAILBOX_PORT_IMAP
        $cwsMbh->setMailboxUsername('nikalas10@ya.ru');
        $cwsMbh->setMailboxPassword('hgnk2310');
        $cwsMbh->setMailboxSecurity(\Cws\MailBounceHandler\Handler::MAILBOX_SECURITY_SSL); // default const MAILBOX_SECURITY_NOTLS
        $cwsMbh->setMailboxCertValidate(); // default const MAILBOX_CERT_NOVALIDATE
        //$cwsMbh->setMailboxName('SPAM'); // default 'INBOX'
        if ($cwsMbh->openImapRemote() === false) {
            $error = $cwsMbh->getError();
            return;
        }

        // process mails!
        $result = $cwsMbh->processMails();
        if (!$result instanceof \Cws\MailBounceHandler\Models\Result) {
            $error = $cwsMbh->getError();
        } else {
            // continue with Result
            $counter = $result->getCounter();
            echo '<h2>Counter</h2>';
            echo 'total : '.$counter->getTotal().'<br />';
            echo 'fetched : '.$counter->getFetched().'<br />';
            echo 'processed : '.$counter->getProcessed().'<br />';
            echo 'unprocessed : '.$counter->getUnprocessed().'<br />';
            echo 'deleted : '.$counter->getDeleted().'<br />';
            echo 'moved : '.$counter->getMoved().'<br />';

            $mails = $result->getMails();
            echo '<h2>Mails</h2>';
            foreach ($mails as $mail) {
                if (!$mail instanceof \Cws\MailBounceHandler\Models\Mail) {
                    continue;
                }
                echo '<h3>'.$mail->getToken().'</h3>';
                echo 'subject : '.$mail->getSubject().'<br />';
                echo 'type : '.$mail->getType().'<br />';
                echo 'recipients :<br />';
                foreach ($mail->getRecipients() as $recipient) {
                    if (!$recipient instanceof \Cws\MailBounceHandler\Models\Recipient) {
                        continue;
                    }
                    echo '- '.$recipient->getEmail().'<br />';
                }
            }
        }


    }
}
