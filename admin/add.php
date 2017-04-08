<?php

require_once('../config.php');

require_login();

$context = required_param('context');
validate_context($context);

$accept = optional_param('accept', false);
$cancel = optional_param('cancel', false);
$returnurl = optional_param('returnurl', "{$CONFIG->wwwroot}/entities.php?context={$context}#main");

if ($cancel !== false) {
    redirect($returnurl);
}

$model = get_base_model();
$model['title'] = 'Добавление элемента';
$model['context'] = $context;

if (post_data_submitted() && $accept !== false) {
    $result = EntityManager::add_object_from_submit();
    if (is_numeric($result)) {
        redirect("{$CONFIG->wwwroot}/entity.php?id={$result}");
    } else if (is_array($result)) {
        $model['errors'] = $result['errors'];
        $model['content'] = $result['values']['content'];
        unset($result['values']['content']);
        $model['params'] = $result['values'];
    }
}

echo $Twig->render('admin/' . get_entity_template($context), $model);
