<?php
namespace Desirene\Propel\Generator\Manager;
use Propel\Generator\Util\SqlParser;

class SqlManager extends \Propel\Generator\Manager\SqlManager
{
  /**
   * @param string $datasource A datasource name.
   */
  public function insertSql($datasource = null)
  {
      $statementsToInsert = [];
      foreach($this->getProperties($this->getSqlDbMapFilename()) as $sqlFile => $database)
      {
        if(!isset($statementsToInsert[$database]))
        {
          $statementsToInsert[$database] = [];
        }
        
        $filename = $this->getWorkingDirectory() . DIRECTORY_SEPARATOR . $sqlFile;

        if(file_exists($filename))
        {
          foreach (SqlParser::parseFile($filename) as $sql) {
            $statementsToInsert[$database][] = $sql;
          }
        }
        else
        {
          $this->log(sprintf("File %s doesn't exist", $filename));
        }
      }

      foreach($statementsToInsert as $database => $sqls)
      {
        if(!$this->hasConnection($database))
        {
          if(null !== $datasource && $this->hasConnection($datasource))
          {
            $database = $datasource;
          }
          else
          {
            $this->log(sprintf("No connection available for %s database", $database));
            continue;
          }
        }
        
        $con = $this->getConnectionInstance($database);
        $con->transaction(function () use ($con, $sqls) {
          foreach ($sqls as $sql) {
            try {
              $stmt = $con->prepare($sql);
              $stmt->execute();
            } catch (\Exception $e) {
              $message = sprintf('SQL insert failed: %s', $sql);
              throw new \Exception($message, 0, $e);
            }
          }
        });

        $this->log(sprintf('%d queries executed for %s database.', count($sqls), $database));
      }

      return true;
  }
}