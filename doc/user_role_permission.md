# 使用者角色與權限

角色與權限是使用 [laravel-permission](https://github.com/spatie/laravel-permission)，可以搭配做使用。

## Table of Contents
- [新增新的權限](#新增新的權限)
- [為方法新增權限檢查](#為方法新增權限檢查)

## 新增新的權限
1. 至 `RolesAndPermissionsSeeder` 中新增權限 `名稱` 與 `顯示名稱`。
    ```php
    $permissions = [
        ...
        ['name' => 'Foo:Write', 'description' => 'Foo...boo....'],
    ];
    ```
2. 執行 `php artisan db:seed --class RolesAndPermissionsSeeder` 將權限新增至資料庫。

## 為方法新增權限檢查
1. 將 `CheckPermissionTrait` 加入至 Controller 中
    ```php
    class DemoController extends Controller
    {
        use CheckPermissionTrait;
        
        ...
    }
    ```

2. 在建構式中指定要檢查的方法

    可用方法有：
    - `checkPermissionApiResource`: 自動建立 API 資源控制器的權限。
    - `checkPermission`: 手動指定權限名稱與方法名稱。
    
    ```php
    public function __construct()
    {
        $this->checkPermissionApiResource();
        $this->checkPermission('User:Write', 'changePassword');
    }
    ```