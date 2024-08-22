<?php

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class create_customers_table extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        (new Builder($schema))->create('customers', function (Table $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('gender');
            $table->string('country');
            $table->string('city');
            $table->string('email');
            $table->string('username');
            $table->string('password');
            $table->string('phone');
            $table->timestamps();
        });
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        (new Builder($schema))->dropIfExists('customers');
    }
}
