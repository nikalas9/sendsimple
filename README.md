# Lite SendSimple 2

Адрес проекта: http://sendsimple.net/

Платформа SendSimple предназначена для организации email-маркетинга по собственной базе контактов. Она предоставляет инструменты для сбора, хранения и обработки данных контактов, запуска рассылок, сегментации базы и гибкой персонализации писем, а также детальной статистики.

Система предоставляет удобный механизм для работы с контактами. Контакты для удобства объединены в базы контактов. Один контакт может находится в разных базах одновременно и иметь разные статусы, для более гибкой организации работы.

Разделение всех данных системы, баз контактов, шаблонов, рассылок происходит на группы, это позволяет разграничить работу между менеджерами компании.

В системе возможно осуществлять следующие виды рассылок:
- массовые рассылки по базам контактов
- новостные рассылки, с анонсом публикаций компании
- приветственные письма (отправляются для подтверждения подписки)
- транзакционные письма, которые отправляются в индивидуальном порядке в ответ на события, генерируемые системой (используя API интеграцию)

Система предоставляет возможность получать статистику,
по отправленным рассылкам и подробные сведения по каждой рассылке детально:
- открытия
- переходы
- отписки
- ссылки


### Demo доступ к Lite версии: 
 
 Адрес для входа: http://demo.sendsimple.net/

 логин: neo
 
 пароль: neo


### Установка и настройка к Lite версии:

- Для разработки использовался framework yii2.
- Минимальная требуемая PHP-версия Yii - это PHP 5.4. Лучше использовать PHP 7.
- Для php необходимо включить php_imap extension.
- База данных Postgresql.

Устанавливать проекта:
```bash
git pull https://github.com/nikalas9/sendsimple/
```
Скопировать /environments/demo-dev в /environments/dev.

Для файла конфигурации /environments/dev/config/console-local.php указать доступ в базу.

Для файла конфигурации /environments/dev/config/web-local.php указать доступ в базу.

Для файла конфигурации /environments/dev/config/params-local.php указать адресс сайта.

Заустить в терминале php init , с параметром 0 (для dev среды).

После этого файлы конфигурации окажутся из /environments/dev/config в /config

Залить базу проекта, для этого необходимо выполнить:

```bash
php yii migrate --migrationPath=@vendor/amnah/yii2-user/migrations
php yii migrate --migrationPath=@yii/log/migrations/
php yii migrate
```

Или взять дамп из /environments/data/pg.sql

Если админ панель работает, след шаг настройка процессов отвечающих за рассылку писем:

В фон добавить выполнение след процессов:
```bash
php yii pre-contact
php yii mail-send
php yii mail-bounce
```
Работу процессов в фоне можно настроить через сервис мониторинга Monit

/etc/monit/conf-available/sender
```bash
check process yii_mail_send matching "yii mail-send"
   stop program  = "/usr/bin/pkill -f 'mail-send'"
   if does not exist then exec /bin/su - username -c "/usr/bin/php /home/username/web/demo.sendsimple.net/public_html/sendsimple/yii mail-send"

check process yii_pre_contact matching "yii pre-contact"
   stop program  = "/usr/bin/pkill -f 'pre-contact'"
   if does not exist then exec /bin/su - username -c "/usr/bin/php /home/username/web/demo.sendsimple.net/public_html/sendsimple/yii pre-contact"

check process yii_mail_bounce matching "yii mail-bounce"
   stop program  = "/usr/bin/pkill -f 'mail-bounce'"
   if does not exist then exec /bin/su - username -c "/usr/bin/php /home/username/web/demo.sendsimple.net/public_html/sendsimple/yii mail-bounce"
```


### Ключевые особенности Pro версии 

- Планировщик рассылок
- Дайджест рассылка
- Персонализация
- Сегментация
- Блочный конструктор писем
- Готовые шаблоны писем
- Календарь планирования
- Многоязычность
- Импорт базы подписчиков
- Интеграция по API
- Статистика


### Вспомогательный материал

- Инструкция использования (https://docs.google.com/document/d/1Bczt92d0FfQccDIP-SR6ExQf5s4EhPVUE1vQ6StLcIg/edit?usp=sharing)
- Создание шаблона (https://docs.google.com/document/d/1vpCiefHPy7NEE8617XBXDFwf1lv-5sy2WM6QtIQ5pnE/edit?usp=sharing)
- Формирование готового шаблона (https://docs.google.com/document/d/15kpUdWNy_Ius4qXrCRE28gZTlAHNOc2gV2YddzZCTnI/edit?usp=sharing)
- Интеграция API (https://docs.google.com/document/d/1str9JrRm6nNck9PFuZYycIwTuEdcMXgahPkl48VVFK0/edit?usp=sharing)
- Правило составления рассылки (https://docs.google.com/document/d/1pNsYWRdP1bhEEV63ECl9mxNyeEcoYDet7l08TuLdsy8/edit?usp=sharing)


