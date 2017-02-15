<?php

use yii\db\Migration;

class m170203_094338_migrate2 extends Migration
{
    public function up()
    {
        $this->insert('tbl_ingredient', [
            'id' => 1,
            'available' => 1,
            'name' => 'Яйцо'
        ]);
        $this->insert('tbl_ingredient', [
            'id' => 2,
            'available' => 1,
            'name' => 'Молоко'
        ]);
        $this->insert('tbl_ingredient', [
            'id' => 3,
            'available' => 1,
            'name' => 'Сметана'
        ]);
        $this->insert('tbl_ingredient', [
            'id' => 4,
            'available' => 1,
            'name' => 'Мука'
        ]);
    }

    public function down()
    {
        $this->truncateTable('tbl_cookbook');
        $this->truncateTable('tbl_dish');
        $this->truncateTable('tbl_ingredient');
    }
}
