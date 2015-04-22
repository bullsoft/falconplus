<?php
use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\PropertyGenerator;
use Zend\Code\Generator\FileGenerator;
use Zend\Code\Generator\MethodGenerator;
use Zend\Code\Generator\DocBlock\Tag;
use Zend\Code\Reflection\ClassReflection;

class ModelTask extends \Phalcon\CLI\Task
{
    public function mainAction(array $params = array())
    {
        if (empty($params)) {
            echo "DB服务不能为空";
            exit(1);
        }

        $namespace = $this->di->getConfig()->application->ns . 'Models';
        $modelDir = APP_MODULE_DIR . "app/models/";

        $dbService = reset($params);
        $connection = $this->di->get($dbService);
        $tables = $connection->listTables();

        foreach($tables as $table) {
            $className = \Phalcon\Text::camelize($table);
            $filePath = $modelDir. $className . ".php";
            $fullClassName = $namespace . '\\' . $className;
            
            if (class_exists($fullClassName)) {
                $generator = ClassGenerator::fromReflection(new ClassReflection(new $fullClassName));
            } else {
                $generator = new ClassGenerator();
            }
            
            $docblock = DocBlockGenerator::fromArray(array(
                'shortDescription' => 'Phalcon Model: ' . $className,
                'longDescription'  => '此文件由代码自动生成，代码依赖PhalconPlus和Zend\Code\Generator',
                'tags'             => array(
                    array(
                        'name'        => 'namespace',
                        'description' => rtrim($namespace, "\\"),
                    ),
                    array(
                        'name'        => 'version',
                        'description' => '$Rev:'. date("Y-m-d H:i:s") .'$',
                    ),
                    array(
                        'name'        => 'license',
                        'description' => 'PhalconPlus(http://plus.phalconphp.org/license-1.0.html)',
                    ),
                ),
            ));

            $generator->setName($className)
                      ->setDocblock($docblock)
                      ->setExtendedClass("\\PhalconPlus\Base\Model");
            
            $columns = $connection->fetchAll("DESC $table", Phalcon\Db::FETCH_ASSOC);
            $columnsDefaultMap = $this->getDefaultValuesMap($columns);

            $onConstructBody = "";
            $columnMapBody = "return array(\n";

            foreach($connection->describeColumns($table) as $columnObj) {
                $columnName = $columnObj->getName();
                $camelizeColumnName = lcfirst(\Phalcon\Text::camelize($columnName));
                $onConstructBody .= '$this->'.$camelizeColumnName
                                 . ' = ' . var_export($columnsDefaultMap[$columnName], true)
                                 . ";\n";
                $columnMapBody .= "    '{$columnName}' => '{$camelizeColumnName}', \n";
                $property = PropertyGenerator::fromArray(array(
                    'name' => $columnName,
                    'defaultvalue' => $columnsDefaultMap[$columnName],
                    'flags' => PropertyGenerator::FLAG_PUBLIC,
                    'docblock' => array(
                        'shortDescription' => '',
                        'tags' => array(
                            array(
                                'name' => 'var',
                                'description' => $this->getTypeString($columnObj->getType()),
                            ),
                            array(
                                'name' => 'table',
                                'description' => $table,
                            ),
                        )
                    ),
                ));
                $generator->removeProperty($columnName);
                $generator->addPropertyFromGenerator($property);
            }
            
            $columnMapBody .= ");\n";
            
            $generator->hasMethod("onConstruct") && $generator->removeMethod("onConstruct");
            $generator->hasMethod("columnMap") && $generator->removeMethod("columnMap");
            $generator->hasMethod("getSource") && $generator->removeMethod("getSource");
                      
            $generator->addMethod(
                    'onConstruct',
                    array(),
                    MethodGenerator::FLAG_PUBLIC,
                    $onConstructBody,
                    DocBlockGenerator::fromArray(array(
                        'shortDescription' => 'Set the baz property',
                        'longDescription'  => null,
                       
                    ))
            );

            $generator->addMethod(
                    'columnMap',
                    array(),
                    MethodGenerator::FLAG_PUBLIC,
                    $columnMapBody,
                    DocBlockGenerator::fromArray(array(
                        'shortDescription' => 'Set the baz property',
                        'longDescription'  => null,
                    ))
                );

            
            if(!$generator->hasMethod("initialize")) {
                $generator->addMethod(
                    'initialize',
                    array(),
                    MethodGenerator::FLAG_PUBLIC,
                    'parent::initialize();' . "\n" . '$this->setConnectionService("'. $dbService .'");' . "\n"
                );
            }

            $generator->addMethod(
                'getSource',
                array(),
                MethodGenerator::FLAG_PUBLIC,
                "return '{$table}';\n",
                DocBlockGenerator::fromArray(array(
                    'shortDescription' => '返回模型对应的表名',
                    'longDescription'  => null,
                       
                ))
            );
            $file = new FileGenerator();
            $file->setFilename($filePath);
            $file->setNamespace($namespace);
            $file->setClass($generator);
            $file->write();
        }
    }

    private function getTypeString($type)
    {
        switch($type) {
            case \Phalcon\Db\Column::TYPE_INTEGER:
                return "integer";
            case \Phalcon\Db\Column::TYPE_DATE:
                return "date";
            case \Phalcon\Db\Column::TYPE_CHAR:
            case \Phalcon\Db\Column::TYPE_TEXT:
            case \Phalcon\Db\Column::TYPE_VARCHAR:
                return "string";
            case \Phalcon\Db\Column::TYPE_DATETIME:
                return "datetime";
            case \Phalcon\Db\Column::TYPE_FLOAT:
            case \Phalcon\Db\Column::TYPE_DOUBLE:
            case \Phalcon\Db\Column::TYPE_DECIMAL:
                return "float";
            case \Phalcon\Db\Column::TYPE_BOOLEAN:
                return "bool";
            default:
                return "unknown";
        }
    }

    private function getDefaultValuesMap($columns)
    {
        $ret = array();
        foreach ($columns as $item) {
            if($item['Type'] == 'timestamp' && $item['Default'] == 'CURRENT_TIMESTAMP') {
                $item['Default'] = '0000-00-00 00:00:00';
            }
            $ret[$item['Field']] = $item['Default'];
        }
        return $ret;
    }
}