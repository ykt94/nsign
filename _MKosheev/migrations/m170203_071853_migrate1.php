<?php

use yii\db\Migration;

class m170203_071853_migrate1 extends Migration
{
    public function up()
    {
        $this->createTable('tbl_ingredient', [
            'id' => 'pk',
            'available' => 'tinyint(1) NOT NULL DEFAULT 1',
            'name' => 'string(255) UNIQUE NOT NULL'
        ], 'Engine=InnoDB');

        $this->createTable('tbl_dish', [
            'id' => 'pk',
            'available' => 'tinyint(1) NOT NULL DEFAULT 1',
            'name' => 'string(255) UNIQUE NOT NULL',
            'description' => 'text NULL'
        ], 'Engine=InnoDB');

        $this->createTable('tbl_cookbook', [
            'dish_id' => 'int(11) NOT NULL',
            'ingredient_id' => 'int(11) NOT NULL',
            'PRIMARY KEY(`dish_id`, `ingredient_id`)'
        ], 'Engine=InnoDB');

        $this->addForeignKey('fk_dish', 'tbl_cookbook', ['dish_id'], 'tbl_dish', ['id'], 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_ingredient', 'tbl_cookbook', ['ingredient_id'], 'tbl_ingredient', ['id'], 'RESTRICT', 'CASCADE');
    }

    public function down()
    {
        $this->truncateTable('tbl_cookbook');
        $this->dropTable('tbl_dish');
        $this->dropTable('tbl_ingredient');
        return true;
    }
}
