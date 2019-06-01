<?php

namespace App\Http\Controllers;

trait CheckPermissionTrait
{
    /**
     * 設定方法需檢查的權限。
     * @param string       $permissionName 權限名稱
     * @param string|array $methodNames    方法的名稱
     */
    protected function checkPermission(string $permissionName, $methodNames)
    {
        $this->middleware("permission:{$permissionName}", ['only' => (array) $methodNames]);
    }

    /**
     * 自動將 ApiResource 預設的 Method 加入權限。
     * 'xxx:Read' => ['index', 'show']
     * 'xxx:Write' => ['store', 'update', 'destroy']
     */
    protected function checkPermissionApiResource()
    {
        $permissionPrefix = str_replace('Controller', '', preg_split("#(\\\\|\\/)#", static::class)[3]);
        $this->checkPermission("{$permissionPrefix}:Read", ['index', 'show']);
        $this->checkPermission("{$permissionPrefix}:Write", ['store', 'update', 'destroy']);
    }
}