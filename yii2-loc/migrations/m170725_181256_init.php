<?php

use yii\db\Migration;

class m170725_181256_init extends Migration
{
     public function safeUp()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('{{%language}}', [
            'id' => $this->primaryKey()->notNull(), // Ідентифікаційний 
            'url' => $this->string()->notNull(),
            'local' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'code' => $this->string()->notNull(),
            'default' => $this->integer()->defaultValue(0), // По вмовчанню яка мова

            'status' => $this->smallInteger()->defaultValue(10), // Статус (Активний, Деактивний)
            'updated_at' => $this->integer()->notNull(), // Дата створення
            'created_at' => $this->integer()->notNull(), // Дата оновлення
        ], $tableOptions);

            $this->addCommentOnTable('{{%language}}', 'Таблиця мов');
            $this->addCommentOnColumn('{{%language}}', 'id', 'ІД номер');
            $this->addCommentOnColumn('{{%language}}', 'url', 'Адреса');
            $this->addCommentOnColumn('{{%language}}', 'local', 'Папка');
            $this->addCommentOnColumn('{{%language}}', 'name', 'Назва');
            $this->addCommentOnColumn('{{%language}}', 'code', 'код (UA, RU, EN...)');
            $this->addCommentOnColumn('{{%language}}', 'default', 'По мовчанню');
            $this->addCommentOnColumn('{{%language}}', 'status', 'По мовчанню');
            $this->addCommentOnColumn('{{%language}}', 'updated_at', 'Дата оновлення');
            $this->addCommentOnColumn('{{%language}}', 'created_at', 'Дата створення');

            $this->insert('{{%language}}', ['id' => 1, 'url' => 'en', 'local' => 'en-EN', 'name' => 'English', 'default' => 0, 'updated_at' => time(), 'created_at' => time(), 'code' => 'US']);
            $this->insert('{{%language}}', ['id' => 2, 'url' => 'ru', 'local' => 'ru-RU', 'name' => 'Русский', 'default' => 0, 'updated_at' => time(), 'created_at' => time(), 'code' => 'RU']);
            $this->insert('{{%language}}', ['id' => 3, 'url' => 'uk', 'local' => 'uk-UA', 'name' => 'Українська', 'default' => 1, 'updated_at' => time(), 'created_at' => time(), 'code' => 'UA']);
        
        $this->createTable('{{%country}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),

            'status' => $this->smallInteger()->defaultValue(10),
            'updated_at' => $this->integer(),
            'created_at' => $this->integer(),
        ], $tableOptions);

            $this->addCommentOnTable('{{%country}}', 'Таблиця країн');
            $this->addCommentOnColumn('{{%country}}', 'id', 'ІД номер');
            $this->addCommentOnColumn('{{%country}}', 'title', 'Назва');
            $this->addCommentOnColumn('{{%country}}', 'status', 'Статус');
            $this->addCommentOnColumn('{{%country}}', 'created_at', 'Дата реєстрації');
            $this->addCommentOnColumn('{{%country}}', 'updated_at', 'Дата останього онолвення інформації');
        
        $this->createTable('{{%region}}', [
            'id' => $this->primaryKey(),
            'country_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),

            'status' => $this->smallInteger()->defaultValue(10),
            'updated_at' => $this->integer(),
            'created_at' => $this->integer(),
        ], $tableOptions);

            $this->addCommentOnTable('{{%region}}', 'Таблиця регіонів');
            $this->addCommentOnColumn('{{%region}}', 'id', 'ІД номер');
            $this->addCommentOnColumn('{{%region}}', 'country_id', 'ІД країни');
            $this->addCommentOnColumn('{{%region}}', 'title', 'Назва');
            $this->addCommentOnColumn('{{%region}}', 'status', 'Статус');
            $this->addCommentOnColumn('{{%region}}', 'created_at', 'Дата реєстрації');
            $this->addCommentOnColumn('{{%region}}', 'updated_at', 'Дата останього онолвення інформації');

            // Creates index key

            $this->createIndex('{{%region-country_id}}', '{{%region}}', 'country_id', false);

            // Creats foreign key

            $this->addForeignKey('{{%fk-region-country_id}}', '{{%region}}', 'country_id', '{{%country}}', 'id');
        
        $this->createTable('{{%type}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'level' => $this->integer(2)->defaultValue(0),
            'parent_type' => $this->integer()->defaultValue(0),
            'code' => $this->string()->notNull(),

            'status' => $this->smallInteger()->defaultValue(10),
            'updated_at' => $this->integer(),
            'created_at' => $this->integer(),
        ], $tableOptions);

            $this->addCommentOnTable('{{%type}}', 'Таблиця типів');
            $this->addCommentOnColumn('{{%type}}', 'id', 'ІД номер');
            $this->addCommentOnColumn('{{%type}}', 'title', 'Назва');
            $this->addCommentOnColumn('{{%type}}', 'level', 'рівень типу');
            $this->addCommentOnColumn('{{%type}}', 'parent_type', 'батько типу');
            $this->addCommentOnColumn('{{%type}}', 'code', 'Код типу');
            $this->addCommentOnColumn('{{%type}}', 'status', 'Статус');
            $this->addCommentOnColumn('{{%type}}', 'created_at', 'Дата реєстрації');
            $this->addCommentOnColumn('{{%type}}', 'updated_at', 'Дата останього онолвення інформації');

            $this->insert('{{%type}}', ['title' => 'city', 'code' => 'city', 'status' => 10, 'created_at' => time(), 'updated_at' => time()]);
            $this->insert('{{%type}}', ['title' => 'urban-type settlement', 'code' => 'city', 'status' => 10, 'created_at' => time(), 'updated_at' => time()]);
            $this->insert('{{%type}}', ['title' => 'village', 'code' => 'city', 'status' => 10, 'created_at' => time(), 'updated_at' => time()]);
            $this->insert('{{%type}}', ['title' => 'city ​​of regional significance', 'code' => 'city', 'status' => 10, 'created_at' => time(), 'updated_at' => time()]);
            $this->insert('{{%type}}', ['title' => 'male', 'code' => 'sex', 'status' => 10, 'created_at' => time(), 'updated_at' => time()]);
            $this->insert('{{%type}}', ['title' => 'female', 'code' => 'sex', 'status' => 10, 'created_at' => time(), 'updated_at' => time()]);
            $this->insert('{{%type}}', ['title' => 'found', 'code' => 'type_post', 'status' => 10, 'created_at' => time(), 'updated_at' => time()]);
            $this->insert('{{%type}}', ['title' => 'lost', 'code' => 'type_post', 'status' => 10, 'created_at' => time(), 'updated_at' => time()]);
            $this->insert('{{%type}}', ['title' => 'document', 'code' => 'tag_post', 'status' => 10, 'created_at' => time(), 'updated_at' => time()]);
            $this->insert('{{%type}}', ['title' => 'key', 'code' => 'tag_post', 'status' => 10, 'created_at' => time(), 'updated_at' => time()]);
            $this->insert('{{%type}}', ['title' => 'stolen', 'code' => 'type_post', 'status' => 10, 'created_at' => time(), 'updated_at' => time()]);
            $this->insert('{{%type}}', ['title' => 'plaza', 'code' => 'type_place', 'status' => 10, 'created_at' => time(), 'updated_at' => time()]);
            $this->insert('{{%type}}', ['title' => 'park', 'code' => 'type_place', 'status' => 10, 'created_at' => time(), 'updated_at' => time()]);
            $this->insert('{{%type}}', ['title' => 'bag', 'code' => 'tag_post', 'status' => 10, 'created_at' => time(), 'updated_at' => time()]);
        
        $this->createTable('{{%translate}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'translate' => $this->string()->notNull(),
            'code' => $this->string()->notNull(),
            'local' => $this->string()->notNull(),

            'status' => $this->smallInteger()->defaultValue(10),
            'updated_at' => $this->integer(),
            'created_at' => $this->integer(),
        ], $tableOptions);

            $this->addCommentOnTable('{{%translate}}', 'Таблиця перекладів');
            $this->addCommentOnColumn('{{%translate}}', 'id', 'ІД номер');
            $this->addCommentOnColumn('{{%translate}}', 'title', 'Що перекласти');
            $this->addCommentOnColumn('{{%translate}}', 'translate', 'Переклад');
            $this->addCommentOnColumn('{{%translate}}', 'code', 'Код');
            $this->addCommentOnColumn('{{%translate}}', 'local', 'Деректива');
            $this->addCommentOnColumn('{{%translate}}', 'status', 'Статус');
            $this->addCommentOnColumn('{{%translate}}', 'created_at', 'Дата реєстрації');
            $this->addCommentOnColumn('{{%translate}}', 'updated_at', 'Дата останього онолвення інформації');

            $this->insert('{{%translate}}', ['title' => 'Ukraine', 'translate' => 'Україна', 'local' => 'uk-UA', 'code' => 'country', 'status' => 10, 'created_at' => time(), 'updated_at' => time()]);
            $this->insert('{{%translate}}', ['title' => 'found', 'translate' => 'Знайдено', 'local' => 'uk-UA', 'code' => 'type_post', 'status' => 10, 'created_at' => time(), 'updated_at' => time()]);
            $this->insert('{{%translate}}', ['title' => 'lost', 'translate' => 'Загублено', 'local' => 'uk-UA', 'code' => 'type_post', 'status' => 10, 'created_at' => time(), 'updated_at' => time()]);
            $this->insert('{{%translate}}', ['title' => 'Chernivtsi', 'translate' => 'Чернівецька обл.', 'local' => 'uk-UA', 'code' => 'region', 'status' => 10, 'created_at' => time(), 'updated_at' => time()]);
            $this->insert('{{%translate}}', ['title' => 'Chernivtsi', 'translate' => 'м. Чернівці', 'local' => 'uk-UA', 'code' => 'city', 'status' => 10, 'created_at' => time(), 'updated_at' => time()]);
            $this->insert('{{%translate}}', ['title' => 'document', 'translate' => 'Документ', 'local' => 'uk-UA', 'code' => 'tag_post', 'status' => 10, 'created_at' => time(), 'updated_at' => time()]);
            $this->insert('{{%translate}}', ['title' => 'key', 'translate' => 'Ключ', 'local' => 'uk-UA', 'code' => 'tag_post', 'status' => 10, 'created_at' => time(), 'updated_at' => time()]);
            $this->insert('{{%translate}}', ['title' => 'stolen', 'translate' => 'Викрадено', 'local' => 'uk-UA', 'code' => 'type_post', 'status' => 10, 'created_at' => time(), 'updated_at' => time()]);
            $this->insert('{{%translate}}', ['title' => 'plaza', 'translate' => 'Площа', 'local' => 'uk-UA', 'code' => 'type_place', 'status' => 10, 'created_at' => time(), 'updated_at' => time()]);
            $this->insert('{{%translate}}', ['title' => 'bag', 'translate' => 'Сумка', 'local' => 'uk-UA', 'code' => 'tag_post', 'status' => 10, 'created_at' => time(), 'updated_at' => time()]);
            $this->insert('{{%translate}}', ['title' => 'Odesa', 'translate' => 'м. Одеса', 'local' => 'uk-UA', 'code' => 'city', 'status' => 10, 'created_at' => time(), 'updated_at' => time()]);
        
        $this->createTable('{{%tag}}', [
            'id' => $this->primaryKey(),
            'type_id' => $this->string()->notNull(),
            'post_id' => $this->integer()->notNull(),
            'code' => $this->string()->notNull(),

            'status' => $this->smallInteger()->defaultValue(10),
            'updated_at' => $this->integer(),
            'created_at' => $this->integer(),
        ], $tableOptions);

            $this->addCommentOnTable('{{%tag}}', 'Таблиця тегів');
            $this->addCommentOnColumn('{{%tag}}', 'id', 'ІД номер');
            $this->addCommentOnColumn('{{%tag}}', 'type_id', 'Тип тегу');
            $this->addCommentOnColumn('{{%tag}}', 'post_id', 'Номер посту');
            $this->addCommentOnColumn('{{%tag}}', 'code', 'Код типу');
            $this->addCommentOnColumn('{{%tag}}', 'status', 'Статус');
            $this->addCommentOnColumn('{{%tag}}', 'created_at', 'Дата реєстрації');
            $this->addCommentOnColumn('{{%tag}}', 'updated_at', 'Дата останього онолвення інформації');

        $this->createTable('{{%city}}', [
            'id' => $this->primaryKey(),
            'region_id' => $this->integer()->notNull(),
            'type_id' => $this->integer()->notNull()->defaultValue(1),
            'title' => $this->string()->notNull(),

            'status' => $this->smallInteger()->defaultValue(10),
            'updated_at' => $this->integer(),
            'created_at' => $this->integer(),
        ], $tableOptions);

            $this->addCommentOnTable('{{%city}}', 'Таблиця міст');
            $this->addCommentOnColumn('{{%city}}', 'id', 'ІД номер');
            $this->addCommentOnColumn('{{%city}}', 'region_id', 'ІД області');
            $this->addCommentOnColumn('{{%city}}', 'type_id', 'ІД категорії міста/смт/сила');
            $this->addCommentOnColumn('{{%city}}', 'title', 'Назва');
            $this->addCommentOnColumn('{{%city}}', 'status', 'Статус');
            $this->addCommentOnColumn('{{%city}}', 'created_at', 'Дата реєстрації');
            $this->addCommentOnColumn('{{%city}}', 'updated_at', 'Дата останього онолвення інформації');

            // Creates index key

            $this->createIndex('{{%city-region_id}}', '{{%city}}', 'region_id', false);
            $this->createIndex('{{%city-type_id}}', '{{%city}}', 'type_id', false);

            // Creats foreign key

            $this->addForeignKey('{{%fk-city-region_id}}', '{{%city}}', 'region_id', '{{%region}}', 'id');
            $this->addForeignKey('{{%fk-city-type_id}}', '{{%city}}', 'type_id', '{{%type}}', 'id');

        $this->createTable('{{%user}}', [ // Таблиця користувачів
            'id' => $this->primaryKey(), // ІД номер
            'auth_key' => $this->string(32)->notNull(), // Ключь
            'password_hash' => $this->string()->notNull(), // Пароль
            'password_reset_token' => $this->string()->unique(), // Токен для відновлення паролю

            // Контактна інформація
            'email' => $this->string()->unique(), // Електронна пошта, має бути обов'язкова для заповнення але не для зберігання'
            'phone' => $this->string(19)->unique(), // Телефон

            // Часова зона
            'timezone' => $this->string(),

            // Додаткова інформація
            'administration' => $this->smallInteger(1)->defaultValue(0),
            'language_id' => $this->integer()->notNull(), // Мова
            'authorization_date' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10), // Статус
            'created_at' => $this->integer()->notNull(), // Дата реєстрація
            'updated_at' => $this->integer()->notNull(), // Дата останього оновлення інформаії
        ], $tableOptions);

            $this->addCommentOnTable('{{%user}}', 'Таблиця користувачів');
            $this->addCommentOnColumn('{{%user}}', 'id', 'ІД номер');
            $this->addCommentOnColumn('{{%user}}', 'auth_key', 'Ключь');
            $this->addCommentOnColumn('{{%user}}', 'password_hash', 'Пароль');
            $this->addCommentOnColumn('{{%user}}', 'password_reset_token', 'Токен для відновлення паролю');
            $this->addCommentOnColumn('{{%user}}', 'email', 'Електронна пошта');
            $this->addCommentOnColumn('{{%user}}', 'timezone', 'Годинний пояс');
            $this->addCommentOnColumn('{{%user}}', 'administration', 'Адмінмістратор (якого рівня)');
            $this->addCommentOnColumn('{{%user}}', 'language_id', 'Мова');
            $this->addCommentOnColumn('{{%user}}', 'authorization_date', 'Дата останього авторизування');
            $this->addCommentOnColumn('{{%user}}', 'phone', 'Телефон');
            $this->addCommentOnColumn('{{%user}}', 'status', 'Статус');
            $this->addCommentOnColumn('{{%user}}', 'created_at', 'Дата реєстрації');
            $this->addCommentOnColumn('{{%user}}', 'updated_at', 'Дата останього онолвення інформації');

            $this->createIndex('{{%user-language_id}}', '{{%user}}', 'language_id', false);

            $this->addForeignKey('{{%fk-user-language_id}}', '{{%user}}', 'language_id', '{{%language}}', 'id');

        $this->createTable('auth', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'source' => $this->string()->notNull(),
            'source_id' => $this->string()->notNull(),
        ]);

            $this->addForeignKey('fk-auth-user_id-user-id', 'auth', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('{{%profile}}', [ // Таблиця користувачів
            'id' => $this->primaryKey(), // ІД номер
            'user_id' => $this->integer()->notNull(),
            'url_id' => $this->string()->notNull(),
            // Особиста інформація
            'first_name' => $this->string()->notNull(),
            'last_name' => $this->string(),
            'birthday' => $this->string(10), // Дата народження
            'type_sex_id' => $this->integer(1)->notNull()->defaultValue(4), // Пол

            'image' => $this->string()->defaultValue('No image'), // Фото

            'link_vk' => $this->string(),
            'link_fb' => $this->string(),
            'link_ok' => $this->string(),

            // Гео інформація
            'country_id' => $this->integer()->notNull(), // Місто
            'region_id' => $this->integer()->notNull(), // Місто
            'city_id' => $this->integer()->notNull(), // Місто
            'zip_code' => $this->string(), // Місто

            // Додаткова інформація
            'status' => $this->smallInteger()->notNull()->defaultValue(10), // Статус
            'created_at' => $this->integer()->notNull(), // Дата реєстрація
            'updated_at' => $this->integer()->notNull(), // Дата останього оновлення інформаії
        ], $tableOptions);

            $this->addCommentOnTable('{{%profile}}', 'Таблиця з інформацією про користувача');
            $this->addCommentOnColumn('{{%profile}}', 'id', 'ІД номер');
            $this->addCommentOnColumn('{{%profile}}', 'user_id', 'ІД користувача');
            $this->addCommentOnColumn('{{%profile}}', 'url_id', 'ІД користувача');
            $this->addCommentOnColumn('{{%profile}}', 'last_name', 'Прізвище');
            $this->addCommentOnColumn('{{%profile}}', 'first_name', 'І`мя');
            $this->addCommentOnColumn('{{%profile}}', 'birthday', 'Дата народження');
            $this->addCommentOnColumn('{{%profile}}', 'type_sex_id', 'Пол');
            $this->addCommentOnColumn('{{%profile}}', 'country_id', 'Країна');
            $this->addCommentOnColumn('{{%profile}}', 'region_id', 'Регіон');
            $this->addCommentOnColumn('{{%profile}}', 'city_id', 'Місто');
            $this->addCommentOnColumn('{{%profile}}', 'zip_code', 'Поштовий індекс');
            $this->addCommentOnColumn('{{%profile}}', 'image', 'Фото користувача');
            $this->addCommentOnColumn('{{%profile}}', 'link_vk', 'Посилання на вк');
            $this->addCommentOnColumn('{{%profile}}', 'link_fb', 'Посилання на фб');
            $this->addCommentOnColumn('{{%profile}}', 'link_ok', 'посилання на ок');
            $this->addCommentOnColumn('{{%profile}}', 'status', 'Статус');
            $this->addCommentOnColumn('{{%profile}}', 'created_at', 'Дата реєстрації');
            $this->addCommentOnColumn('{{%profile}}', 'updated_at', 'Дата останього онолвення інформації');

            // Creates index key

            $this->createIndex('{{%profile-country_id}}', '{{%profile}}', 'country_id', false);
            $this->createIndex('{{%profile-region_id}}', '{{%profile}}', 'region_id', false);
            $this->createIndex('{{%profile-city_id}}', '{{%profile}}', 'city_id', false);
            $this->createIndex('{{%profile-user_id}}', '{{%profile}}', 'user_id', false);
            $this->createIndex('{{%profile-type_sex_id}}', '{{%profile}}', 'type_sex_id', false);

            // Creats foreign key

            $this->addForeignKey('{{%fk-profile-country_id}}', '{{%profile}}', 'country_id', '{{%country}}', 'id');
            $this->addForeignKey('{{%fk-profile-region_id}}', '{{%profile}}', 'region_id', '{{%region}}', 'id');
            $this->addForeignKey('{{%fk-profile-city_id}}', '{{%profile}}', 'city_id', '{{%city}}', 'id');
            $this->addForeignKey('{{%fk-profile-user_id}}', '{{%profile}}', 'user_id', '{{%user}}', 'id');
            $this->addForeignKey('{{%fk-profile-type_sex_id}}', '{{%profile}}', 'type_sex_id', '{{%type}}', 'id');

        $this->createTable('{{%place}}', [ // Таблиця користувачів
            'id' => $this->primaryKey(), // ІД номер
            'title' => $this->string(), // Прізвище
            'city_id' => $this->integer()->notNull(), // Місто
            'type_id' => $this->integer()->notNull(),
            'image' => $this->string(), // Фото

            // Додаткова інформація
            'status' => $this->smallInteger()->notNull()->defaultValue(10), // Статус
            'created_at' => $this->integer()->notNull(), // Дата реєстрація
            'updated_at' => $this->integer()->notNull(), // Дата останього оновлення інформаії
        ], $tableOptions);

            $this->addCommentOnTable('{{%place}}', 'Таблиця місць');
            $this->addCommentOnColumn('{{%place}}', 'id', 'ІД номер');
            $this->addCommentOnColumn('{{%place}}', 'title', 'Назва місця');
            $this->addCommentOnColumn('{{%place}}', 'city_id', 'Місто');
            $this->addCommentOnColumn('{{%place}}', 'type_id', 'Тип місця (площа, тротуар...)');
            $this->addCommentOnColumn('{{%place}}', 'image', 'Фото місця');
            $this->addCommentOnColumn('{{%place}}', 'status', 'Статус');
            $this->addCommentOnColumn('{{%place}}', 'created_at', 'Дата реєстрації');
            $this->addCommentOnColumn('{{%place}}', 'updated_at', 'Дата останього онолвення інформації');

            // Creates index key

            $this->createIndex('{{%place-city_id}}', '{{%place}}', 'city_id', false);
            $this->createIndex('{{%place-type_id}}', '{{%place}}', 'type_id', false);

            // Creats foreign key

            $this->addForeignKey('{{%fk-place-city_id}}', '{{%place}}', 'city_id', '{{%city}}', 'id');
            $this->addForeignKey('{{%fk-place-type_id}}', '{{%place}}', 'type_id', '{{%type}}', 'id');

        $this->createTable('{{%post}}', [ // Таблиця постів
            'id' => $this->primaryKey(), // ІД номер
            'user_id' => $this->integer()->notNull(), // ІД користувача
            'country_id' => $this->integer()->notNull(), // ІД країни
            'region_id' => $this->integer()->notNull(), // ІД регіону
            'city_id' => $this->integer()->notNull(), // ІД міста
            'place_id' => $this->integer(), // ІД місця
            'is_for_reward' => $this->integer(1)->defaultValue(0),
            'text' => $this->string()->notNull(), // Текст
            'image' => $this->string(), // Фото
            'type_id' => $this->integer()->notNull(),
            'phone' => $this->string(19),
            'type_show_id' => $this->smallInteger(1)->notNull()->defaultValue(0),
            'date_event_unix' => $this->integer(),
            'date_event_normal' => $this->dateTime(),

            'link_vk' => $this->string(),
            'link_fb' => $this->string(),
            'link_ok' => $this->string(),

            // Додаткова інформація
            'status' => $this->smallInteger()->notNull()->defaultValue(10), // Статус
            'created_at' => $this->integer()->notNull(), // Дата реєстрація
            'updated_at' => $this->integer()->notNull(), // Дата останього оновлення інформаії
        ], $tableOptions);

            $this->addCommentOnTable('{{%post}}', 'Таблиця місць');
            $this->addCommentOnColumn('{{%post}}', 'id', 'ІД номер');
            $this->addCommentOnColumn('{{%post}}', 'user_id', 'ІД користувача');
            $this->addCommentOnColumn('{{%post}}', 'country_id', 'ІД країни');
            $this->addCommentOnColumn('{{%post}}', 'region_id', 'ІД регіону');
            $this->addCommentOnColumn('{{%post}}', 'city_id', 'ІД міста');
            $this->addCommentOnColumn('{{%post}}', 'place_id', 'ІД місця');
            $this->addCommentOnColumn('{{%post}}', 'is_for_reward', 'Не безоплатно');
            $this->addCommentOnColumn('{{%post}}', 'text', 'текст посту');
            $this->addCommentOnColumn('{{%post}}', 'phone', 'телефону');
            $this->addCommentOnColumn('{{%post}}', 'type_show_id', 'тип показування інформації');
            $this->addCommentOnColumn('{{%post}}', 'date_event_unix', 'дата загублення в форматі унікс');
            $this->addCommentOnColumn('{{%post}}', 'date_event_normal', 'дата загублення в нормальному форматі');
            $this->addCommentOnColumn('{{%post}}', 'link_vk', 'послання в вк');
            $this->addCommentOnColumn('{{%post}}', 'link_fb', 'посилання в фд');
            $this->addCommentOnColumn('{{%post}}', 'link_ok', 'посилання в ок');
            $this->addCommentOnColumn('{{%post}}', 'type_id', 'Тип оголошення');
            $this->addCommentOnColumn('{{%post}}', 'image', 'Фото місця');
            $this->addCommentOnColumn('{{%post}}', 'status', 'Статус');
            $this->addCommentOnColumn('{{%post}}', 'created_at', 'Дата реєстрації');
            $this->addCommentOnColumn('{{%post}}', 'updated_at', 'Дата останього онолвення інформації');

            // Creates index key

            $this->createIndex('{{%post-user_id}}', '{{%post}}', 'user_id', false);
            $this->createIndex('{{%post-country_id}}', '{{%post}}', 'country_id', false);
            $this->createIndex('{{%post-region_id}}', '{{%post}}', 'region_id', false);
            $this->createIndex('{{%post-city_id}}', '{{%post}}', 'city_id', false);
            $this->createIndex('{{%post-place_id}}', '{{%post}}', 'place_id', false);
            $this->createIndex('{{%post-type_id}}', '{{%post}}', 'type_id', false);

            // Creats foreign key

            $this->addForeignKey('{{%fk-post-user_id}}', '{{%post}}', 'user_id', '{{%user}}', 'id');
            $this->addForeignKey('{{%fk-post-country_id}}', '{{%post}}', 'country_id', '{{%country}}', 'id');
            $this->addForeignKey('{{%fk-post-region_id}}', '{{%post}}', 'region_id', '{{%region}}', 'id');
            $this->addForeignKey('{{%fk-post-city_id}}', '{{%post}}', 'city_id', '{{%city}}', 'id');
            $this->addForeignKey('{{%fk-post-place_id}}', '{{%post}}', 'place_id', '{{%place}}', 'id');
            $this->addForeignKey('{{%fk-post-type_id}}', '{{%post}}', 'type_id', '{{%type}}', 'id');

        $this->createTable('{{%point}}', [ // Таблиця користувачів
            'id' => $this->primaryKey(), // ІД номер
            'user_id' => $this->integer()->notNull(), // Прізвище
            'post_id' => $this->integer()->notNull(), // Місто
            'amount' => $this->smallInteger()->notNull(), // Фото
            'type_id' => $this->integer()->notNull(),

            // Додаткова інформація
            'status' => $this->smallInteger()->notNull()->defaultValue(10), // Статус
            'created_at' => $this->integer()->notNull(), // Дата реєстрація
            'updated_at' => $this->integer()->notNull(), // Дата останього оновлення інформаії
        ], $tableOptions);

            $this->addCommentOnTable('{{%point}}', 'Таблиця поінтів');
            $this->addCommentOnColumn('{{%point}}', 'id', 'ІД номер');
            $this->addCommentOnColumn('{{%point}}', 'user_id', 'Назва місця');
            $this->addCommentOnColumn('{{%point}}', 'post_id', 'Місто');
            $this->addCommentOnColumn('{{%point}}', 'type_id', 'Тип поінта (подарочний, зроблений...)');
            $this->addCommentOnColumn('{{%point}}', 'amount', 'Кількість поінтів');
            $this->addCommentOnColumn('{{%point}}', 'status', 'Статус');
            $this->addCommentOnColumn('{{%point}}', 'created_at', 'Дата реєстрації');
            $this->addCommentOnColumn('{{%point}}', 'updated_at', 'Дата останього онолвення інформації');

            // Creates index key

            $this->createIndex('{{%point-user_id}}', '{{%point}}', 'user_id', false);
            $this->createIndex('{{%point-post_id}}', '{{%point}}', 'post_id', false);
            $this->createIndex('{{%point-type_id}}', '{{%point}}', 'type_id', false);

            // Creats foreign key

            $this->addForeignKey('{{%fk-point-user_id}}', '{{%point}}', 'user_id', '{{%user}}', 'id');
            $this->addForeignKey('{{%fk-point-post_id}}', '{{%point}}', 'post_id', '{{%post}}', 'id');
            $this->addForeignKey('{{%fk-point-type_id}}', '{{%point}}', 'type_id', '{{%type}}', 'id');

        $this->createTable('{{%phone}}', [ // Таблиця користувачів (показувати номера при кожному новому створені з вибором якій номера докласти до цього посту)
            'id' => $this->primaryKey(), // ІД номер
            'post_id' => $this->integer(), // номер посту
            'phone' => $this->string(19)->unique(),
            'type_id' => $this->integer()->notNull(),
            'type_operator_id' => $this->integer()->notNull(),

            // Додаткова інформація
            'status' => $this->smallInteger()->notNull()->defaultValue(10), // Статус
            'created_at' => $this->integer()->notNull(), // Дата реєстрація
            'updated_at' => $this->integer()->notNull(), // Дата останього оновлення інформаії
        ], $tableOptions);

            $this->addCommentOnTable('{{%phone}}', 'Таблиця поінтів');
            $this->addCommentOnColumn('{{%phone}}', 'id', 'ІД номер');
            $this->addCommentOnColumn('{{%phone}}', 'post_id', 'Номер посту');
            $this->addCommentOnColumn('{{%phone}}', 'phone', 'Номер');
            $this->addCommentOnColumn('{{%phone}}', 'type_id', 'Тип телефону (стаціонарний, мобільний)');
            $this->addCommentOnColumn('{{%phone}}', 'type_operator_id', 'Оператор телефону');
            $this->addCommentOnColumn('{{%phone}}', 'status', 'Статус');
            $this->addCommentOnColumn('{{%phone}}', 'created_at', 'Дата реєстрації');
            $this->addCommentOnColumn('{{%phone}}', 'updated_at', 'Дата останього онолвення інформації');

            // Creates index key

            $this->createIndex('{{%phone-post_id}}', '{{%phone}}', 'post_id', false);
            $this->createIndex('{{%phone-type_id}}', '{{%phone}}', 'type_id', false);
            $this->createIndex('{{%phone-type_operator_id}}', '{{%phone}}', 'type_operator_id', false);

            // Creats foreign key

            $this->addForeignKey('{{%fk-phone-post_id}}', '{{%phone}}', 'post_id', '{{%post}}', 'id');
            $this->addForeignKey('{{%fk-phone-type_id}}', '{{%phone}}', 'type_id', '{{%type}}', 'id');
            $this->addForeignKey('{{%fk-phone-type_operator_id}}', '{{%phone}}', 'type_operator_id', '{{%type}}', 'id');

        $this->createTable('{{%image}}', [ // Таблиця картинок
            'id' => $this->primaryKey(), // ІД номер
            'post_id' => $this->integer(), // номер посту
            'image' => $this->string(), // номер посту

            // Додаткова інформація
            'status' => $this->smallInteger()->notNull()->defaultValue(10), // Статус
            'created_at' => $this->integer()->notNull(), // Дата реєстрація
            'updated_at' => $this->integer()->notNull(), // Дата останього оновлення інформаії
        ], $tableOptions);

            $this->addCommentOnTable('{{%image}}', 'Таблиця поінтів');
            $this->addCommentOnColumn('{{%image}}', 'id', 'ІД номер');
            $this->addCommentOnColumn('{{%image}}', 'post_id', 'Номер посту');
            $this->addCommentOnColumn('{{%image}}', 'status', 'Статус');
            $this->addCommentOnColumn('{{%image}}', 'created_at', 'Дата реєстрації');
            $this->addCommentOnColumn('{{%image}}', 'updated_at', 'Дата останього онолвення інформації');

            // Creates index key

            $this->createIndex('{{%image-post_id}}', '{{%image}}', 'post_id', false);

            // Creats foreign key

            $this->addForeignKey('{{%fk-image-post_id}}', '{{%image}}', 'post_id', '{{%post}}', 'id');

        $this->createTable('{{%comment}}', [ // Таблиця коментарів
            'id' => $this->primaryKey(), // ІД номер
            'parent_id' => $this->integer(),
            'email' => $this->string()->notNull(),
            'user_id' => $this->integer(),
            'post_id' => $this->integer()->notNull(), // номер посту
            'text' => $this->text()->notNull(), // номер посту

            // Додаткова інформація
            'status' => $this->smallInteger()->notNull()->defaultValue(10), // Статус
            'created_at' => $this->integer()->notNull(), // Дата реєстрація
            'updated_at' => $this->integer()->notNull(), // Дата останього оновлення інформаії
        ], $tableOptions);

            $this->addCommentOnTable('{{%comment}}', 'Таблиця поінтів');
            $this->addCommentOnColumn('{{%comment}}', 'id', 'ІД номер');
            $this->addCommentOnColumn('{{%comment}}', 'parent_id', 'Батьківський комент');
            $this->addCommentOnColumn('{{%comment}}', 'email', 'Електронна пошта автора коментару');
            $this->addCommentOnColumn('{{%comment}}', 'user_id', 'Користувач');
            $this->addCommentOnColumn('{{%comment}}', 'post_id', 'Номер посту');
            $this->addCommentOnColumn('{{%comment}}', 'text', 'Номер посту');
            $this->addCommentOnColumn('{{%comment}}', 'status', 'Статус');
            $this->addCommentOnColumn('{{%comment}}', 'created_at', 'Дата реєстрації');
            $this->addCommentOnColumn('{{%comment}}', 'updated_at', 'Дата останього онолвення інформації');

            // Creates index key

            $this->createIndex('{{%comment-post_id}}', '{{%comment}}', 'post_id', false);
            $this->createIndex('{{%comment-user_id}}', '{{%comment}}', 'user_id', false);

            // Creats foreign key

            $this->addForeignKey('{{%fk-comment-post_id}}', '{{%comment}}', 'post_id', '{{%post}}', 'id');
            $this->addForeignKey('{{%fk-comment-user_id}}', '{{%comment}}', 'user_id', '{{%user}}', 'id');
    }

    public function safeDown()
    {
        $this->dropTable('{{%language}}');
        $this->dropTable('{{%country}}');
        $this->dropTable('{{%region}}');
        $this->dropTable('{{%type}}');
        $this->dropTable('{{%translate}}');
        $this->dropTable('{{%city}}');
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%auth}}');
        $this->dropTable('{{%profile}}');
        $this->dropTable('{{%place}}');
        $this->dropTable('{{%post}}');
        $this->dropTable('{{%point}}');
        $this->dropTable('{{%phone}}');
        $this->dropTable('{{%image}}');
        $this->dropTable('{{%comment}}');
    }
}
