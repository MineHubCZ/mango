<?php

declare(strict_types=1);

use App\Controllers\Welcome;
use Lemon\Route;

Route::get('/', [Welcome::class, 'handle']);

Route::get('cs', function() {
    return <<<'HTML'
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Exception | Lemon</title>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Source+Code+Pro:wght@300&display=swap');
            * {
                font-family: 'Source Code Pro', monospace !important;
            }
            :root {
                --primary: #282828;
                --secondary: #A29783;
                --red: #AF2923;
                --mid-dark: #928374;
            }
        </style>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Lemon-Framework/static/reporter/dist/css/app.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Lemon-Framework/static/reporter/dist/css/gruvbox.css">
    </head>
    <body class='bg-primary text-secondary'>
        <div class="container px-3 py-5 mx-auto sm:px-0">
            <div class="block p-3 shadow-xl bg-red text-primary">
                <div class="text-xl">Lemon\Config\Exceptions\ConfigException - /vendor/lemon_framework/lemon/src/Lemon/Config/Config.php:60</div>
                <div class="text-2xl">Config key file does not exist</div>
                <div class="text-2xl"></div>
            </div>
            <div id="app">
                <context></context>
            </div>    
        </div>
    </body>
    <script>
    let context = {"error":"\/vendor\/lemon_framework\/lemon\/src\/Lemon\/Config\/Config.php","hints":[],"request":{"path":"\/api\/services\/webisek\/edit","query":"","method":"POST","headers":{"Host":"localhost:8000","User-Agent":"Mozilla\/5.0 (Macintosh; Intel Mac OS X 10.15; rv:107.0) Gecko\/20100101 Firefox\/107.0","Accept":"text\/html,application\/xhtml+xml,application\/xml;q=0.9,image\/avif,image\/webp,*\/*;q=0.8","Accept-Language":"en-US,en;q=0.5","Accept-Encoding":"gzip, deflate, br","DNT":"1","Connection":"keep-alive","Cookie":"CSRF_TOKEN=75ZRBA0xIi2LjPzbu3UwlgTcOqt8Eav4","Upgrade-Insecure-Requests":"1","Sec-Fetch-Dest":"document","Sec-Fetch-Mode":"navigate","Sec-Fetch-Site":"same-origin","Sec-GPC":"1","Content-Length":"63","Origin":"http:\/\/localhost:8000","Pragma":"no-cache","Cache-Control":"no-cache"},"body":"{\"token\":\"74e46a57079bc78cc4892760c2cf90437d73b64e\",\"status\":1}"},"trace":[{"file":"\/vendor\/lemon_framework\/lemon\/src\/Lemon\/Config\/Config.php","code":"<?php\n\ndeclare(strict_types=1);\n\nnamespace Lemon\\Config;\n\nuse Lemon\\Config\\Exceptions\\ConfigException;\nuse Lemon\\Contracts\\Config\\Config as ConfigContract;\nuse Lemon\\Kernel\\Application;\nuse Lemon\\Support\\Filesystem;\nuse Lemon\\Support\\Types\\Arr;\nuse Lemon\\Support\\Types\\Str;\n\nclass Config implements ConfigContract\n{\n    private array $files = [];\n\n    private array $data = [];\n\n    public function __construct(\n        private Application $application\n    ) {\n    }\n\n    \/**\n     * Loads config data from given directory.\n     *\/\n    public function load(string $directory = 'config'): static\n    {\n        $directory = $this->application->file($directory);\n        if (!Filesystem::isDir($directory)) {\n            throw new ConfigException('Directory '.$directory.' does not exist');\n        }\n        static $s = DIRECTORY_SEPARATOR;\n        foreach (Filesystem::listDir($directory) as $path) {\n            $re = '\/^'.preg_quote($directory.$s, '\/').'(.+?)\\.php$\/';\n            if (preg_match($re, $path, $matches)) {\n                $key = Str::replace($matches[1], $s, '.')->value;\n                $this->files[$key] = $path;\n            }\n        }\n\n        return $this;\n    }\n\n    \/**\n     * Returns value for given key in config.\n     *\/\n    public function get(string $key): mixed\n    {\n        $keys = explode('.', $key);\n\n        $part = $keys[0];\n        $keys = array_slice($keys, 1);\n\n        $this->loadPart($part);\n        $last = $this->data[$part];\n        foreach ($keys as $key) {\n            if (!isset($last[$key])) {\n                throw new ConfigException('Config key '.$key.' does not exist');\n            }\n            $last = $last[$key];\n        }\n\n        return $last;\n    }\n\n    \/**\n     * Returns project file for given key in config.\n     *\/\n    public function file(string $key, string $extension = null): string\n    {\n        return $this->application->file($this->get($key), $extension);\n    }\n\n    \/**\n     * Sets key in config for given value.\n     *\/\n    public function set(string $key, mixed $value): static\n    {\n        $keys = explode('.', $key);\n        $part = $keys[0];\n\n        $this->loadPart($part);\n        $last = &$this->data[$part];\n        foreach (array_slice($keys, 1, -1) as $key) {\n            $last = &$last[$key];\n        }\n        $last[Arr::last($keys)] = $value;\n\n        return $this;\n    }\n\n    \/**\n     * Loads part (if not loaded or force is true) into static::$data.\n     *\/\n    public function loadPart(string $part, bool $force = false): void\n    {\n        if (isset($this->data[$part]) && !$force) {\n            return;\n        }\n\n        $path =\n            $this->files[$part]\n            ?? Filesystem::join(__DIR__, '..', Str::capitalize($part)->value, 'config.php');\n\n        if (!file_exists($path)) {\n            throw new ConfigException('Part '.$part.' does not exist');\n        }\n\n        $this->data[$part] = require $path;\n    }\n\n    \/**\n     * Returns all config data.\n     *\/\n    public function data(): array\n    {\n        return $this->data;\n    }\n}\n","line":60},{"file":"\/vendor\/lemon_framework\/lemon\/src\/Lemon\/Config\/Config.php","code":"<?php\n\ndeclare(strict_types=1);\n\nnamespace Lemon\\Config;\n\nuse Lemon\\Config\\Exceptions\\ConfigException;\nuse Lemon\\Contracts\\Config\\Config as ConfigContract;\nuse Lemon\\Kernel\\Application;\nuse Lemon\\Support\\Filesystem;\nuse Lemon\\Support\\Types\\Arr;\nuse Lemon\\Support\\Types\\Str;\n\nclass Config implements ConfigContract\n{\n    private array $files = [];\n\n    private array $data = [];\n\n    public function __construct(\n        private Application $application\n    ) {\n    }\n\n    \/**\n     * Loads config data from given directory.\n     *\/\n    public function load(string $directory = 'config'): static\n    {\n        $directory = $this->application->file($directory);\n        if (!Filesystem::isDir($directory)) {\n            throw new ConfigException('Directory '.$directory.' does not exist');\n        }\n        static $s = DIRECTORY_SEPARATOR;\n        foreach (Filesystem::listDir($directory) as $path) {\n            $re = '\/^'.preg_quote($directory.$s, '\/').'(.+?)\\.php$\/';\n            if (preg_match($re, $path, $matches)) {\n                $key = Str::replace($matches[1], $s, '.')->value;\n                $this->files[$key] = $path;\n            }\n        }\n\n        return $this;\n    }\n\n    \/**\n     * Returns value for given key in config.\n     *\/\n    public function get(string $key): mixed\n    {\n        $keys = explode('.', $key);\n\n        $part = $keys[0];\n        $keys = array_slice($keys, 1);\n\n        $this->loadPart($part);\n        $last = $this->data[$part];\n        foreach ($keys as $key) {\n            if (!isset($last[$key])) {\n                throw new ConfigException('Config key '.$key.' does not exist');\n            }\n            $last = $last[$key];\n        }\n\n        return $last;\n    }\n\n    \/**\n     * Returns project file for given key in config.\n     *\/\n    public function file(string $key, string $extension = null): string\n    {\n        return $this->application->file($this->get($key), $extension);\n    }\n\n    \/**\n     * Sets key in config for given value.\n     *\/\n    public function set(string $key, mixed $value): static\n    {\n        $keys = explode('.', $key);\n        $part = $keys[0];\n\n        $this->loadPart($part);\n        $last = &$this->data[$part];\n        foreach (array_slice($keys, 1, -1) as $key) {\n            $last = &$last[$key];\n        }\n        $last[Arr::last($keys)] = $value;\n\n        return $this;\n    }\n\n    \/**\n     * Loads part (if not loaded or force is true) into static::$data.\n     *\/\n    public function loadPart(string $part, bool $force = false): void\n    {\n        if (isset($this->data[$part]) && !$force) {\n            return;\n        }\n\n        $path =\n            $this->files[$part]\n            ?? Filesystem::join(__DIR__, '..', Str::capitalize($part)->value, 'config.php');\n\n        if (!file_exists($path)) {\n            throw new ConfigException('Part '.$part.' does not exist');\n        }\n\n        $this->data[$part] = require $path;\n    }\n\n    \/**\n     * Returns all config data.\n     *\/\n    public function data(): array\n    {\n        return $this->data;\n    }\n}\n","line":73},{"file":"\/src\/Middlewares\/Auth.php","code":"<?php\n\ndeclare(strict_types=1);\n\nnamespace App\\Middlewares;\n\nuse Lemon\\Contracts\\Config\\Config;\nuse Lemon\\Http\\Request;\nuse Lemon\\Http\\Response;\n\nclass Auth\n{\n    public function onlyAuthenticated(Config $config, Request $request): ?Response\n    {\n        $tokens = array_slice(\n            explode(\"\\n\", file_get_contents($config->file('tokens.file'))),\n            0,\n            -1\n        );\n\n        if (!in_array($request->get('token'), $tokens)) {\n            return response([\n                'code' => 401,\n                'error' => 'Invalid token',\n            ])->code(401);\n        }\n\n        return null;\n    }\n}\n","line":16},{"file":"\/vendor\/lemon_framework\/lemon\/src\/Lemon\/Kernel\/Container.php","code":"<?php\n\ndeclare(strict_types=1);\n\nnamespace Lemon\\Kernel;\n\nuse Lemon\\Kernel\\Exceptions\\ContainerException;\nuse Lemon\\Kernel\\Exceptions\\NotFoundException;\nuse Lemon\\Support\\Types\\Arr;\nuse Psr\\Container\\ContainerInterface;\nuse ReflectionClass;\nuse ReflectionFunction;\nuse ReflectionMethod;\n\n\/\/ TODO add application\nclass Container implements ContainerInterface\n{\n    \/**\n     * Container services.\n     *\n     * @var array<string, ?object>\n     *\/\n    private array $services = [];\n\n    \/**\n     * Service aliases.\n     *\n     * @var array<string, string>\n     *\/\n    private array $aliases = [];\n\n    \/**\n     * Returns service of given class\/alias.\n     *\n     * @throws \\Lemon\\Kernel\\Exceptions\\NotFoundException\n     *\/\n    public function get(string $id): mixed\n    {\n        if (!Arr::hasKey($this->services, $id)) {\n            if (!Arr::hasKey($this->aliases, $id)) {\n                throw new NotFoundException('Service '.$id.' does not exist');\n            }\n            $id = $this->aliases[$id];\n        }\n\n        if (is_null($this->services[$id])) {\n            $this->services[$id] = $this->make($id);\n        }\n\n        return $this->services[$id];\n    }\n\n    \/**\n     * Adds new service.\n     *\n     * @throws \\Lemon\\Kernel\\Exceptions\\NotFoundException\n     *\/\n    public function add(string $service, object $instance = null): static\n    {\n        if (!class_exists($service)) {\n            throw new NotFoundException('Class '.$service.' does not exist');\n        }\n\n        $this->services[$service] = $instance;\n\n        return $this;\n    }\n\n    \/**\n     * Creates new alias.\n     *\n     * @throws \\Lemon\\Kernel\\Exceptions\\NotFoundException\n     *\/\n    public function alias(string $alias, string $class): static\n    {\n        if (!$this->has($class)) {\n            throw new NotFoundException('Service '.$class.' does not exist');\n        }\n        $this->aliases[$alias] = $class;\n\n        return $this;\n    }\n\n    \/**\n     * Returns all registered services.\n     *\/\n    public function services(): array\n    {\n        return Arr::keys($this->services)->content;\n    }\n\n    \/**\n     * Returns whenever service exist.\n     *\/\n    public function has(string $id): bool\n    {\n        return Arr::hasKey($this->services, $id);\n    }\n\n    \/**\n     * Returns whenever service exist.\n     *\/\n    public function hasAlias(string $id): bool\n    {\n        return Arr::hasKey($this->aliases, $id);\n    }\n\n    public function call(callable $callback, array $params): mixed\n    {\n        $fn = is_array($callback) ? new ReflectionMethod(...$callback) : new ReflectionFunction($callback);\n        $injected = [];\n        foreach ($fn->getParameters() as $param) {\n            if ($class = (string) $param->getType()) {\n                if ($this->has($class) || $this->hasAlias($class)) {\n                    $injected[$param->getName()] = $this->get($class);\n                } else {\n                    throw new ContainerException('Parameter of type '.$class.' could not be injected, because its not present in container');\n                }\n            } elseif (isset($params[$param->getName()])) {\n                $injected[$param->getName()] = $params[$param->getName()];\n            } elseif (!$param->isOptional()) {\n                return new ContainerException('Parameter '.$param->getName().' is missing');\n            }\n        }\n\n        return $callback(...$injected);\n    }\n\n    \/**\n     * Returns all aliases.\n     *\/\n    public function aliases(): array\n    {\n        return $this->aliases;\n    }\n\n    \/**\n     * Creates service instance of given class.\n     *\/\n    private function make(string $service): mixed\n    {\n        $class = new ReflectionClass($service);\n        $constructor = $class->getConstructor();\n\n        if (!$constructor) {\n            return new $service();\n        }\n\n        $class_params = $constructor->getParameters();\n        $params = [];\n\n        foreach ($class_params as $param) {\n            $type = (string) $param->getType();\n            $params[] = $this->get($type);\n        }\n\n        return new $service(...$params);\n    }\n}\n","line":126},{"file":"\/vendor\/lemon_framework\/lemon\/src\/Lemon\/Http\/ResponseFactory.php","code":"<?php\n\ndeclare(strict_types=1);\n\nnamespace Lemon\\Http;\n\nuse Exception;\nuse InvalidArgumentException;\nuse Lemon\\Contracts\\Http\\Jsonable;\nuse Lemon\\Contracts\\Http\\ResponseFactory as ResponseFactoryContract;\nuse Lemon\\Contracts\\Templating\\Factory as Templating;\nuse Lemon\\Http\\Responses\\EmptyResponse;\nuse Lemon\\Http\\Responses\\HtmlResponse;\nuse Lemon\\Http\\Responses\\JsonResponse;\nuse Lemon\\Http\\Responses\\TemplateResponse;\nuse Lemon\\Kernel\\Application;\nuse Lemon\\Templating\\Template;\n\nclass ResponseFactory implements ResponseFactoryContract\n{\n    private array $handlers = [];\n\n    public function __construct(\n        private Templating $templating,\n        private Application $application\n    ) {\n    }\n\n    \/**\n     * Creates new response out of given callable.\n     *\/\n    public function make(callable $action, array $params = []): Response\n    {\n        $output = $this->application->call($action, $params);\n\n        return $this->resolve($output);\n    }\n\n    \/**\n     * Returns response depending on given data.\n     *\/\n    public function resolve(mixed $data): Response\n    {\n        if (is_null($data)) {\n            return new EmptyResponse();\n        }\n\n        if (is_scalar($data)) {\n            return new HtmlResponse($data);\n        }\n\n        if (is_array($data)) {\n            return new JsonResponse($data);\n        }\n\n        if ($data instanceof Response) {\n            return $data;\n        }\n\n        if ($data instanceof Jsonable) {\n            return new JsonResponse($data->toJson());\n        }\n\n        if ($data instanceof Template) {\n            return new TemplateResponse($data);\n        }\n\n        throw new Exception('Class '.$data::class.' can\\'t be resolved as response');\n    }\n\n    \/**\n     * Returns response for 400-500 http status codes.\n     *\/\n    public function error(int $code): Response\n    {\n        if (!isset(Response::STATUS_CODES[$code]) || $code < 400) {\n            throw new InvalidArgumentException('Status code '.$code.' is not error status code');\n        }\n\n        if (isset($this->handlers[$code])) {\n            return $this->make($this->handlers[$code]);\n        }\n\n        if ($this->templating->exist(\"errors.{$code}\")) {\n            return new TemplateResponse($this->templating->make(\"errors.{$code}\"), $code);\n        }\n\n        static $s = DIRECTORY_SEPARATOR;\n        $path = __DIR__.$s.'templates'.$s.'error.phtml';\n\n        return new TemplateResponse(new Template(\n            $path,\n            $path,\n            ['code' => $code]\n        ), $code);\n    }\n\n    \/**\n     * Returns response for 400-500 http status codes.\n     *\/\n    public function raise(int $code): Response\n    {\n        return $this->error($code);\n    }\n\n    \/**\n     * Registers custom handler for given status code.\n     *\/\n    public function handle(int $code, callable $action): static\n    {\n        $this->handlers[$code] = $action;\n\n        return $this;\n    }\n}\n","line":34},{"file":"\/vendor\/lemon_framework\/lemon\/src\/Lemon\/Routing\/Router.php","code":"<?php\n\ndeclare(strict_types=1);\n\nnamespace Lemon\\Routing;\n\nuse Lemon\\Contracts\\Http\\ResponseFactory;\nuse Lemon\\Contracts\\Routing\\Router as RouterContract;\nuse Lemon\\Contracts\\Templating\\Factory as TemplateFactory;\nuse Lemon\\Http\\Request;\nuse Lemon\\Http\\Response;\nuse Lemon\\Http\\Responses\\EmptyResponse;\nuse Lemon\\Kernel\\Application;\nuse Lemon\\Routing\\Exceptions\\RouteException;\nuse Lemon\\Support\\Types\\Str;\n\n\/**\n * The Lemon Router.\n *\/\nclass Router implements RouterContract\n{\n    public const REQUEST_METHODS = [\n        'get',\n        'post',\n        'put',\n        'head',\n        'delete',\n        'path',\n        'options',\n    ];\n\n    \/** @see https:\/\/laravel.com\/docs\/9.x\/controllers#actions-handled-by-resource-controller *\/\n    public const CONTROLLER_RESOURCES = [\n        'index' => ['get', '\/'],\n        'create' => ['get', '\/create'],\n        'store' => ['post', '\/create'],\n        'show' => ['get', '\/{target}'],\n        'edit' => ['get', '\/{target}\/edit'],\n        'update' => ['put', '\/{target}'],\n        'delete' => ['get', '\/{target}\/delete'],\n    ];\n\n    private Collection $routes;\n\n    public function __construct(\n        private Application $application,\n        private ResponseFactory $response\n    ) {\n        $this->routes = new Collection();\n    }\n\n    \/**\n     * Creates route for method get.\n     *\/\n    public function get(string $path, callable|array $action): Route\n    {\n        return $this->routes->add($path, 'get', $action);\n    }\n\n    \/**\n     * Creates route for method post.\n     *\/\n    public function post(string $path, callable|array $action): Route\n    {\n        return $this->routes->add($path, 'post', $action);\n    }\n\n    \/**\n     * Creates route for method put.\n     *\/\n    public function put(string $path, callable|array $action): Route\n    {\n        return $this->routes->add($path, 'put', $action);\n    }\n\n    \/**\n     * Creates route for method head.\n     *\/\n    public function head(string $path, callable|array $action): Route\n    {\n        return $this->routes->add($path, 'head', $action);\n    }\n\n    \/**\n     * Creates route for method delete.\n     *\/\n    public function delete(string $path, callable|array $action): Route\n    {\n        return $this->routes->add($path, 'delete', $action);\n    }\n\n    \/**\n     * Creates route for method path.\n     *\/\n    public function path(string $path, callable|array $action): Route\n    {\n        return $this->routes->add($path, 'path', $action);\n    }\n\n    \/**\n     * Creates route for method options.\n     *\/\n    public function options(string $path, callable|array $action): Route\n    {\n        return $this->routes->add($path, 'options', $action);\n    }\n\n    \/**\n     * Creates new route with every request method.\n     *\/\n    public function any(string $path, callable|array $action): Route\n    {\n        foreach (self::REQUEST_METHODS as $method) {\n            $this->routes->add($path, $method, $action);\n        }\n\n        return $this->routes->find($path);\n    }\n\n    \/**\n     * Creates GET route directly returning view.\n     *\n     * @author CoolFido sort of\n     *\/\n    public function template(string $path, ?string $view = null): Route\n    {\n        $view = $view ?? (string) Str::replace($path, '\/', '.');\n\n        return $this->routes->add($path, 'get', fn (TemplateFactory $templates) => $templates->make($view));\n    }\n\n    \/**\n     * Creates collection of routes created in given callback.\n     *\/\n    public function collection(callable $routes): Collection\n    {\n        $original = $this->routes;\n        $this->routes = new Collection();\n        $this->application->call($routes, []);\n        $collection = $this->routes;\n        $this->routes = $original;\n        $this->routes->collection($collection);\n\n        return $collection;\n    }\n\n    \/**\n     * Creates collection of routes created in given file.\n     *\/\n    public function file(string $file): Collection\n    {\n        return $this->collection(function () use ($file) {\n            $router = $this;\n\n            require $this->application->file($file, 'php');\n        });\n    }\n\n    \/**\n     * Generates collection of given controller.\n     *\/\n    public function controller(string $base, string $controller): Collection\n    {\n        if (!class_exists($controller)) {\n            throw new RouteException('Controller '.$controller.' does not exist');\n        }\n\n        return $this->collection(function () use ($controller) {\n            foreach (get_class_methods($controller) as $method) {\n                if (in_array($method, self::REQUEST_METHODS)) {\n                    $this->{$method}('\/', [$controller, $method]);\n                }\n\n                if (isset(self::CONTROLLER_RESOURCES[$method])) {\n                    $resource = self::CONTROLLER_RESOURCES[$method];\n                    $this->{$resource[0]}($resource[1], [$controller, $method]);\n                }\n            }\n        })->prefix($base);\n    }\n\n    \/**\n     * Finds route depending on given request.\n     *\/\n    public function dispatch(Request $request): Response\n    {\n        $result = $this->routes->dispatch(trim($request->path, '\/'));\n\n        if (!$result) {\n            return $this->response->error(404);\n        }\n\n        $route = $result[0];\n        $action = $route->action($request->method);\n\n        if (!$action) {\n            return $this->response->error(400);\n        }\n\n        $prototype = $this->response->make($action, $result[1]);\n        $this->application->add(Response::class, $prototype);\n\n        foreach ($route->middlewares->resolve() as $middleware) {\n            $response = $this->response->make($middleware);\n            if ($response instanceof EmptyResponse || $response === $prototype) {\n                continue;\n            }\n\n            return $response;\n        }\n\n        return $prototype;\n    }\n\n    \/**\n     * Returns all routes.\n     *\/\n    public function routes(): Collection\n    {\n        return $this->routes;\n    }\n}\n","line":204},{"file":"\/vendor\/lemon_framework\/lemon\/src\/Lemon\/Kernel\/Application.php","code":"<?php\n\ndeclare(strict_types=1);\n\nnamespace Lemon\\Kernel;\n\nuse Error;\nuse ErrorException;\nuse Exception;\nuse Lemon\\Contracts;\nuse Lemon\\Http\\Request;\nuse Lemon\\Protection\\Middlwares\\Csrf;\nuse Lemon\\Routing\\Router;\nuse Lemon\\Support\\Filesystem;\nuse Lemon\\Support\\Types\\Str;\nuse Lemon\\Zest;\nuse Throwable;\n\n\/**\n * The Lemon Application.\n *\n * @property \\Lemon\\Routing\\Router            $routing\n * @property \\Lemon\\Config\\Config             $config\n * @property \\Lemon\\Cache\\Cache               $cache\n * @property \\Lemon\\Templating\\Juice\\Compiler $juice\n * @property \\Lemon\\Templating\\Factory        $templating\n * @property \\Lemon\\Support\\Env               $env\n * @property \\Lemon\\Http\\ResponseFactory      $response\n * @property \\Lemon\\Http\\Session              $session\n * @property \\Lemon\\Protection\\Csrf           $csrf\n * @property \\Lemon\\Debug\\Handling\\Handler    $handler\n * @property \\Lemon\\Terminal\\Terminal         $terminal\n * @property \\Lemon\\Debug\\Dumper              $dumper\n * @property \\Lemon\\Events\\Dispatcher         $events\n * @property \\Lemon\\Logging\\Logger            $log\n * @property \\Lemon\\Database\\Database         $database\n * @property \\Lemon\\Validation\\Validator      $validation\n *\/\nfinal class Application extends Container\n{\n    \/**\n     * Current Lemon version.\n     *\/\n    public const VERSION = '3.6.6';\n\n    \/**\n     * Default units with aliases.\n     *\/\n    public const DEFAULTS = [\n        \\Lemon\\Routing\\Router::class => ['routing', Contracts\\Routing\\Router::class],\n        \\Lemon\\Config\\Config::class => ['config', Contracts\\Config\\Config::class],\n        \\Lemon\\Cache\\Cache::class => ['cache', \\Psr\\SimpleCache\\CacheInterface::class, Contracts\\Cache\\Cache::class],\n        \\Lemon\\Templating\\Juice\\Compiler::class => ['juice', Contracts\\Templating\\Compiler::class],\n        \\Lemon\\Templating\\Factory::class => ['templating', Contracts\\Templating\\Factory::class],\n        \\Lemon\\Support\\Env::class => ['env', Contracts\\Support\\Env::class],\n        \\Lemon\\Http\\ResponseFactory::class => ['response', Contracts\\Http\\ResponseFactory::class],\n        \\Lemon\\Http\\Session::class => ['session', Contracts\\Http\\Session::class],\n        \\Lemon\\Protection\\Csrf::class => ['csrf', Contracts\\Protection\\Csrf::class],\n        \\Lemon\\Debug\\Handling\\Handler::class => ['handler', Contracts\\Debug\\Handler::class],\n        \\Lemon\\Terminal\\Terminal::class => ['terminal', Contracts\\Terminal\\Terminal::class],\n        \\Lemon\\Debug\\Dumper::class => ['dumper', Contracts\\Debug\\Dumper::class],\n        \\Lemon\\Events\\Dispatcher::class => ['events', Contracts\\Events\\Dispatcher::class],\n        \\Lemon\\Logging\\Logger::class => ['log', \\Psr\\Log\\LoggerInterface::class, Contracts\\Logging\\Logger::class],\n        \\Lemon\\Database\\Database::class => ['database', Contracts\\Database\\Database::class],\n        \\Lemon\\Validation\\Validator::class => ['validation', Contracts\\Validation\\Validator::class],\n    ];\n\n    \/**\n     * App directory.\n     *\/\n    public readonly string $directory;\n\n    \/**\n     * Creates new application instance.\n     *\/\n    public function __construct(string $directory)\n    {\n        $this->directory = $directory;\n        $this->add(self::class, $this);\n    }\n\n    public function __get(string $name): object\n    {\n        if (!$this->has($name)) {\n            throw new Exception('Undefined property: '.self::class.'::$'.$name);\n        }\n\n        return $this->get($name);\n    }\n\n    \/**\n     * Registers default services.\n     *\/\n    public function loadServices(): void\n    {\n        foreach (self::DEFAULTS as $unit => $aliases) {\n            $this->add($unit);\n            foreach ($aliases as $alias) {\n                $this->alias($alias, $unit);\n            }\n        }\n    }\n\n    \/**\n     * Initializes zests.\n     *\/\n    public function loadZests(): void\n    {\n        Zest::init($this);\n    }\n\n    \/**\n     * Loads error\/exception handlers.\n     *\/\n    public function loadHandler(): void\n    {\n        error_reporting(E_ALL);\n        set_exception_handler([$this, 'handle']);\n        set_error_handler([$this, 'handleError']);\n    }\n\n    \/**\n     * Executes error handler.\n     *\/\n    public function handle(Throwable $problem): void\n    {\n        $this->get('handler')->handle($problem);\n\n        exit;\n    }\n\n    \/**\n     * Converts warnings\/notices to Exception.\n     *\/\n    public function handleError(int $severity, string $error, string $file, int $line): bool\n    {\n        throw new ErrorException($error, 0, $severity, $file, $line);\n    }\n\n    \/**\n     * Loads fundamental commands.\n     *\/\n    public function loadCommands(): void\n    {\n        $commands = new Commands($this->get('terminal'), $this->get('config'), $this);\n        $commands->load();\n    }\n\n    \/**\n     * Returns path of specific file in current project.\n     *\/\n    public function file(string $path, string $extension = null): string\n    {\n        $dir = Filesystem::join(\n            $this->directory,\n            Str::replace($path, '.', DIRECTORY_SEPARATOR)->value\n        );\n\n        $dir = Filesystem::normalize($dir);\n\n        if ($extension) {\n            return $dir.'.'.trim($extension, \" \\t\\n\\r.\");\n        }\n\n        return $dir;\n    }\n\n    public function runsInTerminal(): bool\n    {\n        return PHP_SAPI == 'cli';\n    }\n\n    \/**\n     * Executes whole application.\n     *\/\n    public function boot(): void\n    {\n        try {\n            $this->get('routing')->dispatch($this->get(Request::class))->send();\n        } catch (Exception|Error $e) {\n            $this->handle($e);\n        }\n    }\n\n    public function down(): void\n    {\n        copy(Filesystem::join(__DIR__, 'templates', 'maintenance.php'), $this->file('maintenance', 'php'));\n    }\n\n    public function up(): void\n    {\n        unlink($this->file('maintenance', 'php'));\n    }\n\n    \/**\n     * Initializes whole application for you.\n     *\/\n    public static function init(string $directory, bool $terminal = true): self\n    {\n        $directory = Filesystem::parent($directory);\n        $maintenance = $directory.DIRECTORY_SEPARATOR.'maintenance.php';\n\n        if (file_exists($maintenance)) {\n            require $maintenance;\n\n            exit;\n        }\n\n        \/\/ --- Creating Application instance ---\n        $application = new self($directory);\n\n        \/\/ --- Obtaining request ---\n        if (!$application->runsInTerminal()) {\n            $application->add(Request::class, Request::capture()->injectApplication($application));\n\n            $application->alias('request', Request::class);\n        }\n\n        \/\/ --- Loading default Lemon services ---\n        $application->loadServices();\n\n        \/\/ --- Loading Zests for services ---\n        $application->loadZests();\n\n        \/\/ --- Loading Error\/Exception handlers ---\n        $application->loadHandler();\n\n        \/\/ --- Loading commands ---\n        $application->loadCommands();\n\n        \/* --- The end ---\n         * This function automaticaly boots our app at the end of file\n         *\/\n        register_shutdown_function(function () use ($application, $terminal) {\n            \/* --- Terminal ---\n             * Once we run index.php from terminal via php index.php it will automaticaly start terminal\n             * mode which will work instead of lemonade\n             *\/\n            if ($application->runsInTerminal()) {\n                if ($terminal) {\n                    $application->get('terminal')->run(array_slice($GLOBALS['argv'], 1));\n                }\n\n                return;\n            }\n\n            if (http_response_code() >= 500) {\n                return;\n            }\n\n            $application->get(Router::class)->routes()->middleware(Csrf::class);\n\n            $application->boot();\n        });\n\n        return $application;\n    }\n}\n","line":179},{"file":"\/public\/index.php","code":"<?php\n\ndeclare(strict_types=1);\n\nuse Lemon\\Http\\Request;\n\n$maintenance = __DIR__.'\/..\/maintenance.php';\n\nif (file_exists($maintenance)) {\n    require $maintenance;\n\n    exit;\n}\n\n\/** @var \\Lemon\\Kernel\\Application $application *\/\n$application = include __DIR__.'\/..\/init.php';\n\n$application->add(Request::class, Request::capture()->injectApplication($application));\n$application->alias('request', Request::class);\n\n$application->boot();\n","line":21}]}</script>
    <script src="https://cdn.jsdelivr.net/gh/Lemon-Framework/static/reporter/dist/js/app.js"></script>
    </html>
    HTML;
});
