<?php

namespace TaliumAttributes\Handler;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use TaliumAttributes\helper\FileHelpers as HelperFileHelpers;
use TaliumAttributes\Services\ReflectionMeta;

class RouterHandler
{
    use HelperFileHelpers;

    public function __construct()
    {
    }

    public function attribute()
    {
    }

    public static function findController()
    {
        $appPath = self::app_path();
        $files = File::allFiles($appPath);
        $controllerFiles = [];


        foreach ($files as $file) {
            $filePath = $file->getPathname();
            $fileName = $file->getFilename();
            if (strpos($fileName, 'Controller.php') !== false) {
                $relativePath = str_replace($appPath . DIRECTORY_SEPARATOR, '', $filePath);
                $namespace = str_replace(DIRECTORY_SEPARATOR, '\\', $relativePath);
                $controllerNamespace = 'App\\' . substr($namespace, 0, -4);
                $controllerFiles[] = $controllerNamespace;
            }
        }
        return $controllerFiles;
    }

    public static function build($data): array
    {

        $routers = [];
        // Cek apakah kelas memiliki atribut dan jika memiliki kunci 'prefix'
        if (!empty($data['attribute'])) {
            // Iterasi setiap metode
            foreach ($data['methods'] as $method) {

                // Ambil informasi tentang metode
                $methodName = $method['method_name'];
                $attributes = $method['attributes'];

                // Buat router hanya jika metode memiliki atribut
                if (!empty($attributes)) {
                    // Inisialisasi array untuk menyimpan data router
                    $router = [];

                    // Setel metode HTTP berdasarkan atribut yang dimiliki metode
                    $url_method = '';
                    if (isset($attributes['Get'])) {
                        $router['method'] = 'GET';
                        $url_method = $attributes['Get'];
                    } elseif (isset($attributes['Post'])) {
                        $router['method'] = 'POST';
                        $url_method = $attributes['Post'];
                    } elseif (isset($attributes['Put'])) {
                        $router['method'] = 'PUT';
                        $url_method = $attributes['Put'];
                    } elseif (isset($attributes['Delete'])) {
                        $router['method'] = 'DELETE';
                        $url_method = $attributes['Delete'];
                    } else {
                        // Jika tidak ada atribut HTTP yang ditemukan, lewati metode ini
                        continue;
                    }

                    $router['prefix'] = $data['attribute']['prefix'] ?? $data['attribute']['group']->prefix ?? '';
                    $router['url'] = $url_method;
                    $router['controller'] = [$data['class'], $methodName];
                    $router['guard'] = $attributes['guard'] ?? null;
                    // group

                    if (!empty($data['attribute']['group'])) {
                        $filteredArray = array_filter(collect($data['attribute']['group'])->toArray(), function ($value) {
                            return $value !== null && $value !== '' && $value !== [];
                        });
                        $router['attribute_group'] = $filteredArray;
                    }

                    if (!empty($data['attribute']['group']->middleware)) {
                        $router['middleware'] = $data['attribute']->middleware ?? [];
                    }

                    // Tambahkan middleware ke router jika ada
                    if (!empty($data['attribute']['middleware'])) {
                        $router['middleware'] = $data['attribute']['middleware'];
                    }

                    if (!empty($data['attribute']['group']->name)) {
                        $router['name'] = $data['attribute']['group']->name;
                    }

                    // Tambahkan middleware ke router jika ada
                    if (!empty($data['attribute']['name'])) {
                        $router['name'] = $data['attribute']['name'];
                    }

                    if (!empty($data['attribute']['guard'])) {
                        $router['name'] = $data['attribute']['guard'];
                    }

                    if (!empty($attributes['name'])) {
                        $router['name'] .= "." . $attributes['name'];
                    } else {
                        $router['name'] = !empty($router['name']) ?
                            $router['name'] . "." . $methodName :
                            str_replace('/', '.', ($router['prefix'] . "/" . $method['method_name']));
                    }

                    $routers[] = $router;
                }
            }
        }
        return $routers;
    }

    public static function route()
    {
        $controllerFiles = self::findControllers();

        try {
            if (!empty(Config::get('RouterAttributeNameSpace')) && is_array(Config::get('RouterAttributeNameSpace')))
                $controllerFiles = Config::get('RouterAttributeNameSpace');
            else
                $controllerFiles = self::findControllers();
        } catch (\Throwable $e) {
            throw new \Exception($e->getMessage());
        }
        $rootPath = self::app_path();
        $controllerFiles = array_map(function ($path) use ($rootPath) {
            return str_replace($rootPath, '', $path);
        }, $controllerFiles);
        $routes_list = [];

        foreach ($controllerFiles as $key => $items) {
            foreach ($items as $item) {
                $routes = ReflectionMeta::HirarchyAttributes($item);
                if (!empty($routes['attribute'])) {
                    $arr = self::build((ReflectionMeta::HirarchyAttributes($item)));
                    foreach ($arr as $router) {
                        $routes_list[] = array_merge($router, ["http-contex" => $router['guard'] ?? $key ?? 'web']);
                    }
                }
            }
        }
        foreach ($routes_list as $router) {
            try {

                Route::group([], function () use ($router) {
                    $groups = collect($router['attribute_group'])
                        ->merge($router['http-contex'] === "api" ? ["middleware" => "api", "prefix" => "api/" . ($router['attribute_group']['prefix'] ?? '')] : ["middleware" => "web"])
                        ->toArray();
                    Route::group($groups ?? [], function () use ($router) {
                        if (is_array($router['url'])) {
                            foreach ($router['url'] as $url) {
                                Route::group($router['method_group'] ?? [], function () use ($url, $router) {
                                    Route::{strtolower($router['method'])}($url, $router['controller'])
                                        ->name($router['name'] ?? null);
                                });
                            }
                        } else {
                            Route::group($router['method_group'] ?? [], function () use ($router) {
                                Route::{strtolower($router['method'])}($router['url'], $router['controller'])
                                    ->name($router['name'] ?? null);
                            });
                        }
                    });
                });
            } catch (\Throwable) {
            }
        }
    }


    public static function findControllers()
    {
        $data = ReflectionMeta::findPhpFilesWithClass(app_path());

        $namespaces = [];
        foreach ($data as $classData) {
            $namespaces[$classData['controller']][] = $classData['namespace'];
        }
        return $namespaces;
    }

    public static function pushToConfig()
    {
        $data = self::findControllers();
        $namespaces = "";
        foreach ($data as $key => $classData) {
            $classes = collect($classData)->map(function ($x) {
                return $x . '::class';
            })->toArray();
            $namespaces .= "'" . $key . "' => [\n        " . implode(",\n        ", $classes) . "\n    ],\n";
        }

        $result = "<?php\n\nreturn [\n    " . $namespaces . "];\n";
        $configPath = config_path('ControllerAttributeList.php');
        file_put_contents($configPath, $result);
    }
}
