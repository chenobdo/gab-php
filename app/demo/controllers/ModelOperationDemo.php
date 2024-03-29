<?php
/***********************************
 *             Gab PHP             *
 *                                 *
 * A light php framework for study *
 *                                 *
 *             Gabriel             *
 *  <https://github.com/obdobriel> *
 *                                 *
 ***********************************/

namespace App\Demo\Controllers;

use Framework\App;
use App\Demo\Models\TestTable;
use Exception;

/**
 * ModelOperationDemo Controller
 *
 * @desc default controller
 */
class ModelOperationDemo
{
	public function __construct()
	{}

	public function modelExample()
	{
		try {
            DB::beginTransaction();
            $testTableModel = new TestTable();

            // find one data
            $testTableModel->modelFindOneDemo();
            // find all data
            $testTableModel->modelFindAllDemo();
            // save data
            $testTableModel->modelSaveDemo();
            // delete data
            $testTableModel->modelDeleteDemo();
            // update data
            $testTableModel->modelUpdateDemo([
                   'nickname' => 'gab-php'
                ]);
            // count data
            $testTableModel->modelCountDemo();

            DB::commit();
            return 'success';
        } catch (Exception $e) {
            DB::rollBack();
            return 'fail';
        }
	}
}
