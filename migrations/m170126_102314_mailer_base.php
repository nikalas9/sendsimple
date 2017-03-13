<?php

use yii\db\Migration;

class m170126_102314_mailer_base extends Migration
{
    public function up()
    {
        $tableOptions_pgsql = '';
       
        $this->createTable('{{log_ask}}', [
            'id' =>  $this->primaryKey(),
            'ip' => $this->string(50),
            'cmd' => $this->string(50),
            'query' => $this->text(),
            'request' => $this->text(),
            'result' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions_pgsql);

        $this->createTable('{{%account}}', [
            'id' =>  $this->primaryKey(),
            'from_name' => $this->string(100),
            'from_email' => $this->string(100),
            'smtp_host' => $this->string(100),
            'smtp_port' => $this->string(100),
            'smtp_username' => $this->string(100),
            'smtp_password' => $this->string(100),
            'imap_username' => $this->string(),
            'imap_password' => $this->string(),
            'imap_host' => $this->string(),
            'imap_port' => $this->string(),
            'imap_encryption' => $this->string(10),
            'smtp_encryption' => $this->string(10),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'sort' => $this->integer(),
            'status' => $this->integer()->defaultValue(1),
        ], $tableOptions_pgsql);

        $this->createTable('{{%base}}', [
            'id' =>  $this->primaryKey(),
            'name' => $this->string(),
            'lang_id' => $this->integer(),
            'group_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'sort' => $this->integer(),
            'status' => $this->integer()->defaultValue(1),
        ], $tableOptions_pgsql);

        $this->createTable('{{%black_list}}', [
            'id' =>  $this->primaryKey(),
            'email' => $this->string(),
            'type' => $this->text(),
            'message' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ], $tableOptions_pgsql);

        $this->createTable('{{%city}}', [
            'id' =>  $this->primaryKey(),
            'name' => $this->string(),
            'country_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'status' => $this->smallInteger()->defaultValue(1),
        ], $tableOptions_pgsql);

        $this->createTable('{{%clients}}', [
            'id' =>  $this->primaryKey(),
            'email' => $this->string(100),
            'country_id' => $this->integer(),
            'city_id' => $this->integer(),
            'other' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'status' => $this->smallInteger()->defaultValue(1),
        ], $tableOptions_pgsql);

        $this->createTable('{{%clients_base}}', [
            'id' =>  $this->primaryKey(),
            'status' => $this->smallInteger()->defaultValue(1),
            'client_id' => $this->integer(),
            'base_id' => $this->integer(),
            'file_id' => $this->integer(),
        ], $tableOptions_pgsql);

        $this->createTable('{{%clients_param}}', [
            'id' =>  $this->primaryKey(),
            'alias' => $this->string(),
            'name' => $this->string(),
            'type_id' => $this->string(10),
            'show' => $this->integer()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'sort' => $this->integer(),
            'status' => $this->integer()->defaultValue(1),
        ], $tableOptions_pgsql);

        $this->createTable('{{%country}}', [
            'id' =>  $this->primaryKey(),
            'name' => $this->string(),
            'iso' => $this->string(10),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'status' => $this->integer()->defaultValue(1),
        ], $tableOptions_pgsql);

        $this->createTable('{{%files}}', [
            'id' =>  $this->primaryKey(),
            'name' => $this->string(),
            'file' => $this->string(),
            'date_upload' => $this->integer(),
            'iBook' => $this->smallInteger(),
            'iHeader' => $this->smallInteger(),
            'base_id' => $this->integer(),
            'column' => $this->text(),
            'state' => $this->smallInteger()->defaultValue(1),
            'result' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'status' => $this->smallInteger()->defaultValue(1),
        ], $tableOptions_pgsql);

        $this->createTable('{{%group}}', [
            'id' =>  $this->primaryKey(),
            'name' => $this->string(),
            'site' => $this->string(),
            'account_id' => $this->integer(),
            'domain' => $this->string(),
            'color_class' => $this->string(50),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'sort' => $this->integer(),
            'status' => $this->integer()->defaultValue(1),
        ], $tableOptions_pgsql);

        $this->createTable('{{%lang}}', [
            'id' =>  $this->primaryKey(),
            'name' => $this->string(),
            'main' => $this->smallInteger()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'sort' => $this->integer(),
            'status' => $this->integer()->defaultValue(1),
        ], $tableOptions_pgsql);

        $this->createTable('{{%mailer}}', [
            'id' =>  $this->primaryKey(),
            'group_id' => $this->integer(),
            'base_ids' => $this->text(),
            'account_id' => $this->integer(),
            'lang_id' => $this->integer(),
            'name' => $this->string(),
            'body' => $this->text(),
            'temp_id' => $this->string(100),
            'files' => $this->text(),
            'template_id' => $this->integer(),
            //'news_id' => $this->integer(),
            'date_start' => $this->integer(),
            'max' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'status' => $this->integer()->defaultValue(1),
        ], $tableOptions_pgsql);

        $this->createTable('{{%mailer_data}}', [
            'id' =>  $this->primaryKey(),
            'client_id' => $this->integer(),
            'client_email' => $this->string(),
            'base_id' => $this->integer(),
            'mailer_id' => $this->integer(),
            //'triger_id' => $this->integer(),
            //'welcome_id' => $this->integer(),
            //'news_id' => $this->integer(),
            'lang_id' => $this->integer(),
            'send' => $this->integer(),
            'deliver' => $this->integer(),
            'open' => $this->integer(),
            'spam' => $this->integer(),
            'link' => $this->text(),
            'error' => $this->text(),
            'hash' => $this->string(100),
            'info' => $this->text(),
            'server' => $this->text(),
            'message_id' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'status' => $this->smallInteger()->defaultValue(1),
        ], $tableOptions_pgsql);

        $this->createTable('{{%pages}}', [
            'id' =>  $this->primaryKey(),
            'name' => $this->string(),
            'lang_id' => $this->integer(),
            'alias' =>  $this->string(50),
            'link' => $this->string(),
            'temp_id' => $this->integer(),
            'body' => $this->text(),
            'style' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'sort' => $this->integer(),
            'status' => $this->integer()->defaultValue(1),
        ], $tableOptions_pgsql);

        $this->createTable('{{%tmp_link}}', [
            'id' =>  $this->primaryKey(),
            'mailer_data_id' => $this->integer(),
            'link' => $this->text(),
            'hash' => $this->string(),
            'count' => $this->smallInteger(),
            'created_at' => $this->integer(),
        ], $tableOptions_pgsql);

        $this->createTable('{{%templates}}', [
            'id' =>  $this->primaryKey(),
            'group_id' => $this->integer(),
            'name' => $this->string(),
            'body' => $this->text(),
            'temp_id' => $this->string(50),
            'lang_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'status' => $this->integer()->defaultValue(1),
        ], $tableOptions_pgsql);

        $this->createTable('{{%letter_file}}', [
            'id' =>  $this->primaryKey(),
            'status' => $this->integer()->defaultValue(1),
            'name' => $this->string(),
            'file' => $this->string(),
        ], $tableOptions_pgsql);



        /*
        $this->createIndex('idx_status_8905_00','tbl_account','status',0);
        $this->createIndex('idx_status_8977_01','tbl_base','status',0);
        $this->createIndex('idx_lang_id_8977_02','tbl_base','lang_id',0);
        $this->createIndex('idx_email_903_03','tbl_black_list','email',0);
        $this->createIndex('idx_country_id_9088_04','tbl_city','country_id',0);
        $this->createIndex('idx_status_9089_05','tbl_city','status',0);
        $this->createIndex('idx_country_id_9138_06','tbl_clients','country_id',0);
        $this->createIndex('idx_city_id_9138_07','tbl_clients','city_id',0);
        $this->createIndex('idx_email_9138_08','tbl_clients','email',0);
        $this->createIndex('idx_status_9139_09','tbl_clients','status',0);
        $this->createIndex('idx_client_id_9186_10','tbl_clients_base','client_id',0);
        $this->createIndex('idx_base_id_9186_11','tbl_clients_base','base_id',0);
        $this->createIndex('idx_status_9186_12','tbl_clients_base','status',0);
        $this->createIndex('idx_status_9229_13','tbl_clients_param','status',0);
        $this->createIndex('idx_status_9278_14','tbl_country','status',0);
        $this->createIndex('idx_status_9377_15','tbl_files','status',0);
        $this->createIndex('idx_status_9429_16','tbl_group','status',0);
        $this->createIndex('idx_status_9471_17','tbl_lang','status',0);
        $this->createIndex('idx_group_id_954_18','tbl_mailer','group_id',0);
        $this->createIndex('idx_template_id_954_19','tbl_mailer','template_id',0);
        $this->createIndex('idx_news_id_954_20','tbl_mailer','news_id',0);
        $this->createIndex('idx_status_9541_21','tbl_mailer','status',0);
        $this->createIndex('idx_client_id_9615_22','tbl_mailer_data','client_id',0);
        $this->createIndex('idx_mailer_id_9615_23','tbl_mailer_data','mailer_id',0);
        $this->createIndex('idx_triger_id_9615_24','tbl_mailer_data','triger_id',0);
        $this->createIndex('idx_welcome_id_9615_25','tbl_mailer_data','welcome_id',0);
        $this->createIndex('idx_status_9616_26','tbl_mailer_data','status',0);
        $this->createIndex('idx_base_id_9616_27','tbl_mailer_data','base_id',0);
        $this->createIndex('idx_group_id_9702_28','tbl_news','group_id',0);
        $this->createIndex('idx_status_9702_29','tbl_news','status',0);
        $this->createIndex('idx_rubric_id_9759_30','tbl_news_items','rubric_id',0);
        $this->createIndex('idx_status_9759_31','tbl_news_items','status',0);
        $this->createIndex('idx_status_9807_32','tbl_pages','status',0);
        $this->createIndex('idx_temp_id_9807_33','tbl_pages','temp_id',0);
        $this->createIndex('idx_lang_id_9807_34','tbl_pages','lang_id',0);
        $this->createIndex('idx_user_id_9851_35','tbl_profile','user_id',0);
        $this->createIndex('idx_hash_0054_36','tbl_temp_link','hash',0);
        $this->createIndex('idx_mailer_data_id_0054_37','tbl_temp_link','mailer_data_id',0);
        $this->createIndex('idx_group_id_01_38','tbl_templates','group_id',0);
        $this->createIndex('idx_lang_id_01_39','tbl_templates','lang_id',0);
        $this->createIndex('idx_status_0101_40','tbl_templates','status',0);
        $this->createIndex('idx_group_id_0245_41','tbl_triger','group_id',0);
        $this->createIndex('idx_UNIQUE_email_0308_42','tbl_user','email',1);
        $this->createIndex('idx_UNIQUE_username_0308_43','tbl_user','username',1);
        $this->createIndex('idx_role_id_0309_44','tbl_user','role_id',0);
        $this->createIndex('idx_status_0376_45','tbl_user2','status',0);
        $this->createIndex('idx_provider_id_0416_46','tbl_user_auth','provider_id',0);
        $this->createIndex('idx_user_id_0416_47','tbl_user_auth','user_id',0);
        $this->createIndex('idx_UNIQUE_token_0453_48','tbl_user_token','token',1);
        $this->createIndex('idx_user_id_0453_49','tbl_user_token','user_id',0);
        $this->createIndex('idx_group_id_0493_50','tbl_welcome','group_id',0);
        $this->createIndex('idx_lang_id_0494_51','tbl_welcome','lang_id',0);
        $this->createIndex('idx_status_0494_52','tbl_welcome','status',0);

        $this->execute('SET foreign_key_checks = 0');
        $this->addForeignKey('fk_tbl_clients_9179_00','{{%tbl_clients_base}}', 'client_id', '{{%tbl_clients}}', 'id', 'CASCADE', 'NO ACTION' );
        $this->addForeignKey('fk_tbl_base_9179_01','{{%tbl_clients_base}}', 'base_id', '{{%tbl_base}}', 'id', 'CASCADE', 'NO ACTION' );
        $this->addForeignKey('fk_tbl_user_9842_02','{{%tbl_profile}}', 'user_id', '{{%tbl_user}}', 'id', 'CASCADE', 'NO ACTION' );
        $this->addForeignKey('fk_tbl_role_03_03','{{%tbl_user}}', 'role_id', '{{%tbl_role}}', 'id', 'CASCADE', 'NO ACTION' );
        $this->addForeignKey('fk_tbl_user_041_04','{{%tbl_user_auth}}', 'user_id', '{{%tbl_user}}', 'id', 'CASCADE', 'NO ACTION' );
        $this->addForeignKey('fk_tbl_user_0448_05','{{%tbl_user_token}}', 'user_id', '{{%tbl_user}}', 'id', 'CASCADE', 'NO ACTION' );
        $this->execute('SET foreign_key_checks = 1;');
        */
    }

    public function down()
    {

        return false;
    }
}
