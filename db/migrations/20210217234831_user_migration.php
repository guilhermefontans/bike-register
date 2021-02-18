<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UserMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('bikes');
        $table->addColumn('description', 'string', ['limit' => 255])
            ->addColumn('model', 'string', ['limit' => 50])
            ->addColumn('price', 'float')
            ->addColumn('purchase_date', 'datetime')
            ->addColumn('buyer_name', 'string', ['limit' => 50])
            ->addColumn('store_name', 'string', ['limit' => 100])
            ->create();
    }
}
