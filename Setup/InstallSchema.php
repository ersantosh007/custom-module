<?php


namespace Bluethink\Actionlog\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
		$installer = $setup;
		$installer->startSetup();

		/**
		 * Start Creating table bluethink_actionlog
		 */
		$table = $installer->getConnection()->newTable(
			$installer->getTable('bluethink_actionlog')
		)->addColumn(
			'actionlog_id',
			\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
			null,
			['identity' => true,  'nullable' => false, 'primary' => true],
			'Entity Id'
		)->addColumn(
			'user_name',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => true],
			'News Username'
		)->addColumn(
			'full_name',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => true,'default' => null],
			'Fullname'
		)->addColumn(
			'action_type',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => true,'default' => null],
			'Action Type'
		)->addColumn(
			'object',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => true,'default' => null],
			'Object'
		)->addColumn(
			'created_at',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			null,
			['nullable' => false],
			'Created At'
		)->addColumn(
			'store_ids',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => true,'default' => null],
			'Store Views'
		)->setComment(
			'Actionlog item'
		);
		$installer->getConnection()->createTable($table);
        /**
		 * End creating table bluethink_actionlog
		 */
        /**
         * Start Create table 'bluethink_activesession'
         */
		$table = $installer->getConnection()->newTable(
			$installer->getTable('bluethink_activesession')
		)->addColumn(
			'activesession_id',
			\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
			null,
			['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
			'Entity Id'
		)->addColumn(
			'user_name',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => true],
			'News Username'
		)->addColumn(
			'full_name',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => true,'default' => null],
			'Fullname'
		)->addColumn(
			'logged_at',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => true,'default' => null],
			'World publish date'
		)->addColumn(
			'ip_address',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => true,'default' => null],
			'Ip Address'
		)->addColumn(
			'user_location',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => true,'default' => null],
			'Location'
		)->addColumn(
			'recent_activity',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => true,'default' => null],
			'Recent Activity'
		)->addColumn(
			'for_login_filter',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => true,'default' => null],
			'For Login Filter'
		)->addColumn(
			'active_user_id',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => true,'default' => null],
			'Active User Id'
		)->addColumn(
			'active_session',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => true,'default' => null],
			'Active Session'
		)->setComment(
			'Activesession item'
		);
		$installer->getConnection()->createTable($table);
        /**
         * End Create table 'bluethink_activesession'
         */
        /**
         * Start Create table 'bluethink_loginattempt'
        */
		$table = $installer->getConnection()->newTable(
			$installer->getTable('bluethink_loginattempt')
		)->addColumn(
			'loginattempt_id',
			\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
			null,
			['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
			'Entity Id'
		)->addColumn(
			'user_name',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => true],
			'News Username'
		)->addColumn(
			'full_name',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => true,'default' => null],
			'Fullname'
		)->addColumn(
			'logg_attempt',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			null,
			['nullable' => true,'default' => null],
			'World publish date'
		)->addColumn(
			'ip_address',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => true,'default' => null],
			'Ip Address'
		)->addColumn(
			'location',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => true,'default' => null],
			'Location'
		)->addColumn(
			'user_agent',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => true,'default' => null],
			'User Agent'
		)->setComment(
			'Activesession item'
		);
		$installer->getConnection()->createTable($table);
        /**
         * End Create table 'bluethink_loginattempt'
        */
        /**
         * Start Create table 'bluethink_visithistory')
        */
		$table = $installer->getConnection()->newTable(
			$installer->getTable('bluethink_visithistory')
		)->addColumn(
			'visithistory_id',
			\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
			null,
			['identity' => true, 'nullable' => false, 'primary' => true],
			'Entity Id'
		)->addColumn(
			'user_name',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => true],
			'News Username'
		)->addColumn(
			'full_name',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => true,'default' => null],
			'Fullname'
		)->addColumn(
			'session_start',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			null,
			['nullable' => false],
			'Session Start'
		)->addColumn(
			'session_end',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			null,
			['nullable' => false],
			'Session End'
		)->addColumn(
			'ip_address',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => true,'default' => null],
			'Ip Address'
		)->addColumn(
			'location',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => true,'default' => null],
			'Location'
		)->addColumn(
			'random_number',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => true,'default' => null],
			'Random Number'
		)->setComment(
			'Activesession item'
		);
		$installer->getConnection()->createTable($table);
		/**
         * End Create table 'bluethink_visithistory'
        */
        /**
         * Start Create table 'bluethink_visitlisting'
        */
		$table = $installer->getConnection()->newTable(
			$installer->getTable('bluethink_visitlisting')
		)->addColumn(
			'visitlisting_id',
			\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
			null,
			['identity' => true, 'nullable' => false, 'primary' => true],
			'Visitlisting Id'
		)->addColumn(
			'page_name',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => true],
			'Page Name'
		)->addColumn(
			'page_url',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => true,'default' => null],
			'Page Url'
		)->addColumn(
			'stay_duration',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			null,
			['nullable' => false],
			'Stay Duration'
		)->setComment(
			'Activesession item'
		);
		$installer->getConnection()->createTable($table);
        /**
         * End Create table 'bluethink_visitlisting'
        */
		$installer->endSetup();
	}
}