<?php
/**
 * @auth guest
 * @time 2021-9-6 0:52
 * @description 创建
 */
namespace idescript\package\media\package\factory;
interface videoFactory{

    // 获取视频分类列表
    public function getCategoryList($parentId,...$args);

    // 创建视频分类
    public function createCategory($data,...$args);

    // 修改视频分类
    public function updateCategory($data,...$args);

    // 删除视频分类
    public function deleteCategory($data,...$args);

    // 视频合并
    public function videoMontage($data,...$args);

    // 获取视频详情
    public function getVideoMage($data,...$args);

}

