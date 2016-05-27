# Migration to Phalcon 2.1.X

标签（空格分隔）： Phalcon Changelog

> 2012年，一个神奇的框架诞生了。Phalcon，重新定义了PHP框架，甚至挽救了当时已经岌岌可危的PHP语言。经历了无数个版本，从C到Zephir，Phalcon终于迎来了她的第一个LTS版本（2.1.x），而C版本则永远停留在V1.3.4。改用Zephir之后，贡献代码的门槛降低了，社区有更多人来为Phalcon贡献代码，这期间发生了很多变化，新增了很多特性，甚至有一些修改是向后不兼容的，而Phalcon官网上零零散散的有10几篇博客来描述Phalcon的Changelog，看起来非常不方便，因此很有必要列一个完整的清单来描述2.1.x的新特性，激动人心的时刻现在开始。

---

## The Main Changelog

 - Based on [Zephir-Lang][1]
    - Interfaces and type checkings
    - Better debug information
    - Performance Improvements
    
 - Recommend to use PHP 5.6 and above, but below 7.x
 - Many `protected` function marked as `final`
 - Strict Check with `interfaces` and `parameter` types

    ```php
    use Phalcon\Di\InjectionAwareInterface;
    class MyComponent implements InjectionAwareInterface
    {
        public function setDi($di) # Wrong
        {
        
        }
        #public function setDi(DiInterface $di) # Right
    }
    ```


----------


 - Debug
   - New theme
   - Rename Phalcon\Debug\Dump::var() -> Phalcon\Debug\Dump::variable()variable()
   - Rename Phalcon\Debug\Dump::var() -> Phalcon\Debug\Dump::variable()variable()
   - Added name before int/float/numeric/string/bool/null/other variables in Debug\Dump::output


----------


 - PHQL
   - Added support for general SELECT ALL/SELECT `DISTINCT` in PHQL
   - Subqueries
    ```php
$phql = "SELECT c.* FROM Shop\Cars c
        WHERE c.brandId IN (SELECT id FROM Shop\Brands)
        ORDER BY c.name";
$cars = $this->modelsManager->executeQuery($phql);
    ```

   - Implemented Namespace aliases in PHQL
    ```php
    // Before
    $data = $this->modelsManager->executeQuery("
        SELECT r.*, rp.*
        FROM Store\Backend\Models\Robots AS r
        JOIN Store\Backend\Models\RobotsParts AS rp
    ");
    ```
现在你可以在ModelManager中注册别名，省去了写一长串模型名的工作，如：

    ```php
    use Phalcon\Mvc\Model\Manager as ModelsManager;
    // ...
    $di->set(
        'modelsManager',
        function () {
            $modelsManager = new ModelsManager();
            $modelsManager->registerNamespaceAlias(
                'bm',
                 'Store\Backend\Models\Robots'
             );
            return $modelsManager;
        }
    );
    // After
    $data = $this->modelsManager->executeQuery("
        SELECT r.*, rp.*
        FROM bm:Robots AS r
        JOIN bm:RobotsParts AS rp
    ");
    ```
    
   - `String attributes` in models can be marked to `allow empty` string values
   - Added an option to return the SQL to be generated from a Mvc\Model\Query instance
   - PHQL now supports `CASE/WHEN/ELSE` expressions
    ```php
    $robots = $this->modelsManager->executeQuery("
        SELECT
            CASE r.Type
                WHEN 'Mechanical' THEN 1
                WHEN 'Virtual' THEN 2
                ELSE 3
            END
        FROM Store\Robots
    ");
    $robots = $this->modelsManager->executeQuery("
        SELECT
            CASE r.Type
                WHEN 'Mechanical' THEN 1
                WHEN 'Virtual' THEN 2
                ELSE 3
            END
        FROM Store\Robots
    ");
    
    ```

   - Custom Dialect Functions
    ```php
    use Phalcon\Db\Dialect\MySQL as SqlDialect;
    use Phalcon\Db\Adapter\Pdo\MySQL as Connection;
    
    $dialect = new SqlDialect();
    
    // Register a new function called MATCH_AGAINST
    $dialect->registerCustomFunction(
        'MATCH_AGAINST',
        function($dialect, $expression) {
            $arguments = $expression['arguments'];
            return sprintf(
                " MATCH (%s) AGAINST (%)",
                $dialect->getSqlExpression($arguments[0]),
                $dialect->getSqlExpression($arguments[1])
             );
        }
    );
    
    // The dialect must be passed in the connection constructor
    $connection = new Connection(
        [
            "host"          => "localhost",
            "username"      => "root",
            "password"      => "",
            "dbname"        => "test",
            "dialectClass"  => $dialect
        ]
    );
    
    $phql = "SELECT *
       FROM Posts
       WHERE MATCH_AGAINST(title, :pattern:)";
    $posts = $modelsManager->executeQuery($phql, ['pattern' => $pattern]);
    
    ```

   - Values in LIMIT/OFFSET clause are now passed using bound parameters in PHQL
   
    ```php
    $number = '100'; // 下面会抛异常，因为要求是int型
    $robots = $modelsManager->executeQuery(
        'SELECT * FROM Some\Robots LIMIT {number:int}',
        ['number' => $number]
    );
    ```
    
当然，这要求开发者格外注意，所以在类型绑定时，Phalcon提供自动类型转换的设置

```php
\Phalcon\Db::setup(['forceCasting' => true]);
```

以下这些类型绑定时会自动类型转换：
    <table><tr><th>Bind Type</th><th>Action</th></tr><tbody><tr><td>`Column::BIND_PARAM_STR`</td><td>Cast the value as a native PHP string</td></tr><tr><td>`Column::BIND_PARAM_INT`</td><td>Cast the value as a native PHP integer</td></tr><tr><td>`Column::BIND_PARAM_BOOL`</td><td>Cast the value as a native PHP boolean</td></tr><tr><td>`Column::BIND_PARAM_DECIMAL`</td><td>Cast the value as a native PHP double</td></tr></tbody></table>
 
   - Introduced new placeholders in PHQL enclosed in brackets that allow to set the type: `{name:str}` or `{names:array}`
   
    ```php
    $phql = "SELECT * FROM Store\Robots LIMIT {number:int}";
    $robots = $this->modelsManager->executeQuery(
        $phql,
        ['number' => 10]
    );
    
    $phql = "SELECT * FROM Store\Robots WHERE name <> {name:str}";
    $robots = $this->modelsManager->executeQuery(
        $phql,
        ['name' => $name]
    );
    $phql = "SELECT * FROM Store\Robots WHERE id IN ({ids:array})";
    $robots = $this->modelsManager->executeQuery(
        $phql,
        ['ids' => [1, 2, 3, 4]]
    );
        
    ```

   - Bind Types

    <table><tr><th>Bind Type</th><th>Bind Type Constant</th><th>Example</th></tr><tbody><tr><td>str</td><td>`Column::BIND_PARAM_STR`</td><td>`{name:str}`</td></tr><tr><td>int</td><td>`Column::BIND_PARAM_INT`</td><td>`{number:int}`</td></tr><tr><td>double</td><td>`Column::BIND_PARAM_DECIMAL`</td><td>`{price:double}`</td></tr><tr><td>bool</td><td>`Column::BIND_PARAM_BOOL`</td><td>`{enabled:bool}`</td></tr><tr><td>blob</td><td>`Column::BIND_PARAM_BLOB`</td><td>`{image:blob}`</td></tr><tr><td>null</td><td>`Column::BIND_PARAM_NULL`</td><td>`{exists:null}`</td></tr><tr><td>array</td><td>Array of `Column::BIND_PARAM_STR`</td><td>`{codes:array}`</td></tr><tr><td>array-str</td><td>Array of `Column::BIND_PARAM_STR`</td><td>`{names:array}`</td></tr><tr><td>array-int</td><td>Array of `Column::BIND_PARAM_INT`</td><td>`{flags:array}`</td></tr></tbody></table>

----------


 - Db/ORM/Model
    - Phalcon\Mvc\Model::findFirst() now allows hydration
    - Now Mvc\Model checks if an attribute has a default value associated in the database and ignores it from the insert/update generated SQL
    - Support default database value
    ```php
    $robots = new Robots();
    $robots->save(); // use all `default` values
    ```

  - New column type: DOUBLE, BIGINT, BLOB, Support for BIT types in MySQL with binding as booleans
    |  类型            | 值   |  描述  |  适用范围 |
    |  --------        | :--: | :----  |  :------  |
    |  TYPE_INTEGE     | 0 | Integer abstract type | MySQL, Postgre, Oracle|
    |  TYPE_DATE       | 1 | Date abstract type |
    |  TYPE_VARCHAR    | 2 | Varchar abstract type |
    |  TYPE_DECIMAL    | 3 | Decimal abstract type | 
    |  TYPE_DATETIME   | 4 | Datetime abstract type |
    |  TYPE_CHAR       | 5 | Char abstract type |
    |  TYPE_TEXT       | 6 | Text abstract data type |
    |  TYPE_FLOAT      | 7 | Float abstract data type |
    |  TYPE_BOOLEAN    | 8 | Boolean abstract data type |
    |  TYPE_DOUBLE     | 9 | Double abstract data type |
    |  TYPE_TINYBLOB   | 10 | Tinyblob abstract data type |
    |  TYPE_BLOB       | 11 | Blob abstract data type |
    |  TYPE_MEDIUMBLOB | 12 | Mediumblob abstract data type |
    |  TYPE_LONGBLOB   | 13 | Longblob abstract data type |
    |  TYPE_BIGINTEGER | 14 | Big integer abstract type |
    |  TYPE_JSON       | 15 | Json abstract type |
    |  TYPE_JSONB      | 16 | Jsonb abstract type |
    |  TYPE_TIMESTAMP  | 17 | Datetime abstract type |


   - Global setting `orm.cast_on_hydrate` allows casting hydrated attributes to the original types in the mapped tables instead of using strings
也可以通过代码设置：
    ```php
    \Phalcon\Mvc\Model::setup(['castOnHydrate' => true]);
    ```
   - Added groupBy/getGroupBy/having/getHaving to Mvc\Model\Criteria
   - Phalcon\Mvc\Model::count() now return values as integer
   - Relationships with conditionals（条件关系），当某一条件成立时，关系才会存在
    ```php
    use Phalcon\Mvc\Model;
    // Companies have invoices issued to them (paid/unpaid)
    // Invoices model
    class Invoices extends Model
    {
    
    }
    // Companies model
    class Companies extends Model
    {
        public function initialize()
        {
            // All invoices relationship
            $this->hasMany('id', 'Invoices', 'inv_id', [
                'alias' => 'invoices'
            ]);
    
            // Paid invoices relationship
            $this->hasMany('id', 'Invoices', 'inv_id', [
                'alias'    => 'invoicesPaid',
                'params'   => [
                  'conditions' => "inv_status = 'paid'"
                ]
              ]
            );
    
            // Unpaid invoices relationship + bound parameters
            $this->hasMany('id', 'Invoices', 'inv_id', [
                'alias'    => 'invoicesUnpaid',
                'params'   => [
                  'conditions' => "inv_status <> :status:",
                  'bind' => ['status' => 'unpaid']
                ]
              ]
            );
        }
    }
    ```


    -  Added \Phalcon\Mvc\Model\MetaData\Redis adapter.
    -  `Phalcon\Mvc\Model\Validation` is now deprecated, use  `Phalcon\Validation`
    -  Changed the constructor of `Phalcon\Mvc\Model`, The constructor of model classes has been changed, to allow you to pass an array of initialization data:
    ```php
    $customer = new Customer(
        [
            'name'   => 'Peter',
            'status' => 'Active',
        ]
    );
    ```
    
    - Added a prepareSave event to model saving
    - Added support for `OnUpdate` and `OnDelete` foreign key events to the MySQL adapter



----------


   
 - View/Volt
   - Macros
    ```twig
    {%- macro conditionaldate(condition, tdate, ttime, tz) %}
        {% if condition %} from <br/>{{ tdate }}, {{ ttime }} {{ tz }}
        {% endif %}
    {%- endmacro %}
    ```

   - Added 'autoescape' option that allows to globally enable autoescape in any Volt template
   - Added 'autoescape' option that allows to globally enable autoescape in any Volt template
   - Now you can import macros from other files using `{% include "file.volt" %}`
   - Undefined function calls fall back to macro calls in Volt templates
   - Phalcon\Mvc\View supports many views directories, absolute paths
    ```php
    use Phalcon\Mvc\View;
    // ...
    $di->set(
        'view',
        function () {
            $view = new View();
            $view->setViewsDir(
                [
                    '/var/www/htdocs/blog/modules/backend/views/',
                    '/var/www/htdocs/blog/common/views/',
                ]
            );
            $view->setLayoutsDir(
                '/var/www/htdocs/common/views/layouts/'
            );
            return $view;
        }
    );
    ```

----------


 - Session
   - Added Phalcon\Session\Adapter::setName() to change the session name  
    
----------


 - Router
   - Added beforeMatch parameter in `@Route annotation` of Mvc\Router\Annotations
   - Placeholders `:controller` and `:action` in `Mvc\Router` now default to `/([\\w0-9\_\-]+)` instead of `/([\\a-zA-Z0-9\_\-]+)`
   

----------


 - Security
    - Added Phalcon\Security\Random - secure random number generator class. Provides secure random number generator which is suitable for generating session key in HTTP cookies, etc
    - Added Phalcon\Security\Random::base58 - to generate a random base58 string


----------


 - DI
   - Phalcon\Di is now bound to services closures
In the past, we had to pass the dependency injector inside a service closure, if we had to perform some actions inside the closure.  Now we can use `$this` to access the `Phalcon\Di` along with the registered services.
   - Service Resolve overriding
If an object is returned after firing the event beforeServiceResolve in Phalcon\Di, the returned instance overrides the default service localization process.

    ```php
    namespace MyApp\Plugins;
    use Phalcon\Http\Response;
    class ResponseResolverInterceptor
    {
        private $cache = false;
        public function beforeServiceResolve($event, $di, $parameters)
        {
            // Intercept creation of responses
            if ($parameters['name'] == 'response' && $this->cache == false) {
                $response = new Response();
                $response->setHeader('Cache-Control', 'no-cache, must-revalidate');
                return $response;
            }
        }
    }
    ```


----------


 - Phalcon\Dispatcher
    - Disabling the view from an action: Now this much easier; simply `return false`
    - Returning a string makes it the body of the response
    ```php
    use Phalcon\Mvc\Controller;
    class Session extends Controller
    {
        public function welcomeAction()
        {
            return '<h1>Hello world!</h1>';
            // return $this->response->setContent('Hello world')
        }
    }
    ```
    
   - Override dispatcher+view behavior in routes
    ```php
    // Make a redirection if the /help route is matched
    $router->add('/help', [])->match(function () {
        return $this->getResponse()->redirect('https://support.google.com/');
    });
    // Return a string directly from the route
    $router->add('/', [])->match(function () {
        return '<h1>It works</h1>';
    });
    ```


----------


 - Phalcon\Loader
   - Removed support for prefixes strategy in Phalcon\Loader


     [1]: https://zephir-lang.com "Zephir"




