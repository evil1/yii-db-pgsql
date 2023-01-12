<?php

declare(strict_types=1);

namespace Yiisoft\Db\Pgsql;

use Yiisoft\Db\QueryBuilder\AbstractQueryBuilder;
use Yiisoft\Db\Schema\QuoterInterface;
use Yiisoft\Db\Schema\SchemaInterface;

/**
 * The class QueryBuilder is the query builder for PostgresSQL databases.
 */
final class QueryBuilder extends AbstractQueryBuilder
{
    /**
     * Defines a B-tree index method for {@see createIndex()}.
     */
    public const INDEX_B_TREE = 'btree';

    /**
     * Defines a hash index method for {@see createIndex()}.
     */
    public const INDEX_HASH = 'hash';

    /**
     * Defines a GiST index method for {@see createIndex()}.
     */
    public const INDEX_GIST = 'gist';

    /**
     * Defines a GIN index method for {@see createIndex()}.
     */
    public const INDEX_GIN = 'gin';

    /**
     * Defines a BRIN index method for {@see createIndex()}.
     */
    public const INDEX_BRIN = 'brin';

    /**
     * @var array mapping from abstract column types (keys) to physical column types (values).
     *
     * @psalm-var string[]
     */
    protected array $typeMap = [
        SchemaInterface::TYPE_PK => 'serial NOT NULL PRIMARY KEY',
        SchemaInterface::TYPE_UPK => 'serial NOT NULL PRIMARY KEY',
        SchemaInterface::TYPE_BIGPK => 'bigserial NOT NULL PRIMARY KEY',
        SchemaInterface::TYPE_UBIGPK => 'bigserial NOT NULL PRIMARY KEY',
        SchemaInterface::TYPE_CHAR => 'char(1)',
        SchemaInterface::TYPE_STRING => 'varchar(255)',
        SchemaInterface::TYPE_TEXT => 'text',
        SchemaInterface::TYPE_TINYINT => 'smallint',
        SchemaInterface::TYPE_SMALLINT => 'smallint',
        SchemaInterface::TYPE_INTEGER => 'integer',
        SchemaInterface::TYPE_BIGINT => 'bigint',
        SchemaInterface::TYPE_FLOAT => 'double precision',
        SchemaInterface::TYPE_DOUBLE => 'double precision',
        SchemaInterface::TYPE_DECIMAL => 'numeric(10,0)',
        SchemaInterface::TYPE_DATETIME => 'timestamp(0)',
        SchemaInterface::TYPE_TIMESTAMP => 'timestamp(0)',
        SchemaInterface::TYPE_TIME => 'time(0)',
        SchemaInterface::TYPE_DATE => 'date',
        SchemaInterface::TYPE_BINARY => 'bytea',
        SchemaInterface::TYPE_BOOLEAN => 'boolean',
        SchemaInterface::TYPE_MONEY => 'numeric(19,4)',
        SchemaInterface::TYPE_JSON => 'jsonb',
    ];
    private DDLQueryBuilder $ddlBuilder;
    private DMLQueryBuilder $dmlBuilder;
    private DQLQueryBuilder $dqlBuilder;

    public function __construct(QuoterInterface $quoter, SchemaInterface $schema)
    {
        $this->ddlBuilder = new DDLQueryBuilder($this, $quoter, $schema);
        $this->dmlBuilder = new DMLQueryBuilder($this, $quoter, $schema);
        $this->dqlBuilder = new DQLQueryBuilder($this, $quoter, $schema);
        parent::__construct($quoter, $schema, $this->ddlBuilder, $this->dmlBuilder, $this->dqlBuilder);
    }
}
