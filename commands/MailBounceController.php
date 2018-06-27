<?php

namespace app\commands;

use app\components\MailBounceHandler\Handler;
use app\models\Account;
use app\models\MailerData;
use yii\console\Controller;
use yii\console\Exception;
use Yii;

class MailBounceController extends Controller
{
    public function actionIndex()
    {
        Yii::$app->redis->executeCommand("SET", ['mail-bounce_start', time()]);

        while (1) {

            gc_enable();

            Yii::$app->redis->executeCommand("SET", ['mail-bounce_live', time()]);
            Yii::$app->redis->executeCommand("SET", ['mail-bounce_status', 1]);

            $start_time = microtime(true);

            $accounts = Account::find()
                ->andWhere('status = 1')
                ->all();
            foreach ($accounts as $account) {

                try {
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
                    if (in_array($encryption, ['tls','ssl'])) {
                        $cwsMbh->setMailboxSecurity($encryption);
                        $cwsMbh->setMailboxCertValidate();
                    } else {
                        $cwsMbh->setMailboxCertNoValidate();
                    }

                    //$cwsMbh->setMailboxName('SPAM'); // default 'INBOX'
                    if ($cwsMbh->openImapRemote() === false) {
                        throw new Exception( $cwsMbh->getError() );
                    }
                    $cwsMbh->setMaxMessages(1000);

                    // process mails!
                    $result = $cwsMbh->processMails();
                    if (!$result instanceof \app\components\MailBounceHandler\Models\Result) {
                        throw new Exception( $cwsMbh->getError() );
                    } else {
                        $mails = $result->getMails();
                        foreach ($mails as $mail) {
                            if($mail->getRecipients()){
                                $recipient = $mail->getRecipients()[0];
                                //BlackList::import($recipient->getEmail());

                                if($messageId = $mail->getMessageId()){
                                    $model = MailerData::find()
                                        ->andWhere(['message_id'=>$messageId])
                                        ->one();
                                    $model->status = -1;
                                    $result = [
                                        'action' => $recipient->getAction(),
                                        'status' => $recipient->getStatus(),
                                        'bounceType' => $recipient->getBounceType(),
                                        'bounceCat' => $recipient->getBounceCat(),
                                    ];
                                    $model->error = json_encode($result);
                                    $model->save(false);

                                    if ($model->client) {
                                        $model->client->status = -1;
                                        $model->client->update(false);
                                    }
                                }
                            }
                        }
                    }
                } catch (\Exception $e) {
                    $account->status = 0;
                    $account->save(false);
                    throw new \Exception($e->getMessage());
                }
            }

            $load_time = microtime(true) - $start_time;
            if($load_time < Yii::$app->params['timeMailBounceProcess']){
                $sleep_time = Yii::$app->params['timeMailBounceProcess'] - $load_time;
                //echo 'sleep' . $sleep_time . "\n";
                Yii::$app->redis->executeCommand("SET", ['mail-bounce_status', 2]);
                sleep($sleep_time);
            }

            gc_collect_cycles();
        }

    }
}
